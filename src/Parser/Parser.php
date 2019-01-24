<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser;

use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Parser
{
    /** @var string */
    private $code;

    /** @var int */
    private $pointer = 0;

    /** @var Block[]|Key[] */
    private $elements;

    /** @var string */
    private $currentKey;

    /** @var int */
    private $currentKeyLength;

    /** @var string */
    private $currentBlockStart;

    /** @var int */
    private $currentBlockStartLength;

    /** @var int */
    private $codeLength;

    /** @var string */
    private $currentBlockEnd;

    /** @var int */
    private $currentBlockEndLength;

    private function __construct()
    {
    }

    /**
     * Create new parser with provided elements
     *
     * @param Block[]|Key[] $elements
     */
    public static function createWithElements(array $elements) : Parser
    {
        $parser           = new static();
        $parser->elements = $elements;

        return $parser;
    }

    /**
     * @return Block[]|Key[]
     */
    public function getElements() : array
    {
        return $this->elements;
    }

    public function cleanCode(string $code) : string
    {
        return \str_replace(["\r\n", "\r"], "\n", $code);
    }

    /**
     * Convert tabs to spaces
     */
    public function convertTabsToSpaces(string $code, int $tabsize = 4) : string
    {
        $lines = \explode("\n", $code);

        foreach ($lines as $n => $line) {
            while (($tabPos = \strpos($line, "\t")) !== false) {
                $start = \substr($line, 0, $tabPos);
                $tab   = \str_repeat(' ', $tabsize - $tabPos % $tabsize);
                $end   = \substr($line, $tabPos + 1);
                $line  = $start . $tab . $end;
            }

            $lines[$n] = $line;
        }

        return \implode("\n", $lines);
    }

    public function parse(string $code) : string
    {
        $this->code = $this->convertTabsToSpaces($this->cleanCode($code));

        $this->codeLength = \strlen($this->code);
        $this->pointer    = 0;
        $parsedCode       = '';
        $elements         = $this->getElements();

        while ($this->pointer < $this->codeLength) {
            $parsed = $this->findElement($elements);

            if ($parsed !== null) {
                $parsedCode .= $parsed;
            } else {
                $parsedCode .= \htmlspecialchars(\substr($this->code, $this->pointer, 1));
                $this->pointer++;
            }
        }

        return $parsedCode;
    }

    /**
     * @param Key[]|Block[] $elements
     */
    public function findElement(array $elements)
    {
        $parsed = null;

        foreach ($elements as $id => $element) {
            if ($element instanceof Key && $this->findKey($element, \substr($this->code, $this->pointer))) {
                $parsed  = '<span class="' . $element->cssClass() . '">';
                $parsed .= \htmlspecialchars($this->currentKey);
                $parsed .= '</span>';

                $this->pointer += $this->currentKeyLength;
            }

            if ($element instanceof Block && $this->findBlockStart($element, \substr($this->code, $this->pointer))) {
                $blockStart = $this->pointer;
                if ($element->isStartIncluded()) {
                    $parsed = '<span class="' . $element->cssClass() . '">';
                    if (! $element->isHighlightWithChildren()) {
                        $parsed .= \htmlspecialchars($this->currentBlockStart);
                    }
                } else {
                    $parsed  = \htmlspecialchars($this->currentBlockStart);
                    $parsed .= '<span class="' . $element->cssClass() . '">';
                }

                if (! $element->isHighlightWithChildren()) {
                    $this->pointer += $this->currentBlockStartLength;
                }

                $endReached = false;
                while (! $this->findBlockEnd($element, \substr($this->code, $this->pointer))) {
                    if (! $this->isValidContains($element, \substr($this->code, $this->pointer, 1))) {
                        $this->pointer = $blockStart;
                        $parsed        = null;
                        $endReached    = true;
                        break;
                    }

                    $children = $element->children();

                    if ($children !== null) {
                        $childParsed = $this->findElement($children);

                        if ($childParsed !== null) {
                            $parsed .= $childParsed;
                        } else {
                            $parsed .= \htmlspecialchars(\substr($this->code, $this->pointer, 1));
                            $this->pointer++;
                        }
                    } else {
                        $parsed .= \htmlspecialchars(\substr($this->code, $this->pointer, 1));
                        $this->pointer++;
                    }

                    if ($this->pointer > $this->codeLength) {
                        $endReached = true;
                        break;
                    }
                }

                if (! $endReached) {
                    if ($element->isEndIncluded()) {
                        $children = $element->children();

                        if ($children !== null && $element->isHighlightWithChildren()) {
                            $parsed .= $this->findElement($children);
                        } else {
                            $parsed        .= \htmlspecialchars($this->currentBlockEnd);
                            $this->pointer += $this->currentBlockEndLength;
                        }
                    }
                    $parsed .= '</span>';
                }
            }

            if ($parsed !== null) {
                break;
            }
        }

        return $parsed;
    }

    public function findKey(Key $element, string $code) : bool
    {
        if ($element->prefix() === null || $this->isValidPrefix($element->prefix(), $element->prefixLength())) {
            foreach ($element->keys() as $key) {
                $keyLength = \strlen($key);
                if (\strncmp($code, $key, $keyLength) === 0) {
                    continue;
                }

                if ($element->suffix() === null || $this->isValidSuffix($keyLength, $element->suffix(), $element->suffixLength())) {
                    $this->currentKey       = $key;
                    $this->currentKeyLength = $keyLength;
                    return true;
                }
            }
        }

        return false;
    }

    public function findBlockStart(Block $element, string $code) : bool
    {
        if ($element->startPrefix() === null || $this->isValidPrefix($element->startPrefix(), $element->startPrefixLength())) {
            foreach ($element->start() as $key) {
                $keyLength = \strlen($key);
                if (\strncmp($code, $key, $keyLength) === 0) {
                    continue;
                }

                if ($element->startSuffix() === null || $this->isValidSuffix($keyLength, $element->startSuffix(), $element->startSuffixLength())) {
                    $this->currentBlockStart       = $key;
                    $this->currentBlockStartLength = $keyLength;
                    return true;
                }
            }
        }

        return false;
    }

    public function findBlockEnd(Block $element, string $code) : bool
    {
        if ($element->endPrefix() === null || $this->isValidPrefix($element->endPrefix(), $element->endPrefixLength())) {
            foreach ($element->end() as $key) {
                $keyLength = \strlen($key);

                if (\strncmp($code, $key, $keyLength) === 0) {
                    continue;
                }

                if ($element->endSuffix() === null || $this->isValidSuffix($keyLength, $element->endSuffix(), $element->endSuffixLength())) {
                    $this->currentBlockEnd       = $key;
                    $this->currentBlockEndLength = $keyLength;
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if the provided char is valid for the current block
     */
    public function isValidContains(Block $element, string $char) : bool
    {
        if (! $element->hasContains()) {
            return true;
        }

        return (bool) \preg_match('/' . $element->contains() . '/', $char);
    }

    /**
     * Validate given prefix
     *
     * @param string $prefix       Prefix to validate against
     * @param int    $prefixLength Length of the prefix
     *
     * @return bool Whether given prefix is valid
     */
    protected function isValidPrefix(string $prefix, int $prefixLength) : bool
    {
        $code = '';

        if ($this->pointer !== 0) {
            $code = \substr($this->code, $this->pointer - $prefixLength, $prefixLength);
        }

        return (bool) \preg_match('/' . $prefix . '/', $code);
    }

    /**
     * Validate a give suffix
     *
     * @param int    $offset       Pointer offset (usualy length of the key/start)
     * @param string $suffix       Suffix to validate against
     * @param int    $suffixLength Length of the suffix
     *
     * @return bool Whether given suffix is valid
     */
    protected function isValidSuffix(int $offset, string $suffix, int $suffixLength) : bool
    {
        $code = \substr($this->code, $this->pointer + $offset, $suffixLength);
        return (bool) \preg_match('/' . $suffix . '/', $code);
    }
}
