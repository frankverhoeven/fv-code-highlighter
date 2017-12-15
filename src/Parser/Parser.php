<?php

namespace FvCodeHighlighter\Parser;

use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

/**
 * Parser
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class Parser
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var int
     */
    private $pointer = 0;
    /**
     * @var Block[]|Key[]
     */
    private $elements;
    /**
     * @var string
     */
    private $currentKey;
    /**
     * @var int
     */
    private $currentKeyLength;
    /**
     * @var string
     */
    private $currentBlockStart;
    /**
     * @var int
     */
    private $currentBlockStartLength;
    private $codeLength;
    private $currentBlockEnd;
    private $currentBlockEndLength;

    private function __construct()
    {}

    /**
     * Create new parser with provided elements
     *
     * @param Block[]|Key[] $elements
     * @return Parser
     */
    public static function createWithElements(array $elements)
    {
        $parser = new static();
        $parser->elements = $elements;

        return $parser;
    }

    /**
     * @return Block[]|Key[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Cleaup code
     *  Converts line endings to unix style
     *
     * @param string $code
     * @return string
     */
    public function cleanCode($code)
    {
        return str_replace(["\r\n", "\r"], "\n", $code);
    }

    /**
     * Convert tabs to spaces
     *
     * @param string $code
     * @param int $tabsize
     * @return string
     */
    public function convertTabsToSpaces($code, $tabsize = 4)
    {
        $lines = explode("\n", $code);

        foreach ($lines as $n => $line) {
            while (false !== ($tabPos = strpos($line, "\t"))) {
                $start = substr($line, 0, $tabPos);
                $tab = str_repeat(' ', $tabsize - $tabPos % $tabsize);
                $end = substr($line, $tabPos + 1);
                $line = $start . $tab . $end;
            }

            $lines[$n] = $line;
        }

        return implode("\n", $lines);
    }

    public function parse($code)
    {
        $this->code = $this->convertTabsToSpaces($this->cleanCode($code));;
        $this->codeLength = strlen($this->code);
        $this->pointer = 0;
        $parsedCode = '';
        $elements = $this->getElements();

        while ($this->pointer < $this->codeLength) {
            $parsed = $this->findElement($elements);

            if (null !== $parsed) {
                $parsedCode .= $parsed;
            } else {
                $parsedCode .= htmlspecialchars(substr($this->code, $this->pointer, 1));
                $this->pointer++;
            }
        }

        return $parsedCode;
    }

    /**
     * @param array $elements
     * @return null|string
     */
    public function findElement(array $elements)
    {
        $parsed = null;

        foreach ($elements as $id => $element) {
            if ($element instanceof Key && $this->findKey($element, substr($this->code, $this->pointer))) {
                $parsed = '<span class="' . $element->getCssClass() . '">';
                $parsed .= htmlspecialchars($this->currentKey);
                $parsed .= '</span>';

                $this->pointer += $this->currentKeyLength;
            }

            if ($element instanceof Block && $this->findBlockStart($element, substr($this->code, $this->pointer))) {
                $blockStart = $this->pointer;
                if ($element->isStartIncluded()) {
                    $parsed = '<span class="' . $element->getCssClass() . '">';
                    if (!$element->isHighlightWithChildren()) {
                        $parsed .= htmlspecialchars($this->currentBlockStart);
                    }
                } else {
                    $parsed = htmlspecialchars($this->currentBlockStart);
                    $parsed .= '<span class="' . $element->getCssClass() . '">';
                }

                if (!$element->isHighlightWithChildren()) {
                    $this->pointer += $this->currentBlockStartLength;
                }

                $endReached = false;
                while (!$this->findBlockEnd($element, substr($this->code, $this->pointer))) {
                    if (!$this->isValidContains($element, substr($this->code, $this->pointer, 1))) {
                        $this->pointer = $blockStart;
                        $parsed = null;
                        $endReached = true;
                        break;
                    }

                    if (null !== ($children = $element->getChildren())) {
                        $childParsed = $this->findElement($children);

                        if (null !== $childParsed) {
                            $parsed .= $childParsed;
                        } else {
                            $parsed .= htmlspecialchars(substr($this->code, $this->pointer, 1));
                            $this->pointer++;
                        }
                    } else {
                        $parsed .= htmlspecialchars(substr($this->code, $this->pointer, 1));
                        $this->pointer++;
                    }


                    if ($this->pointer > $this->codeLength) {
                        $endReached = true;
                        break;
                    }
                }

                if (!$endReached) {
                    if ($element->isEndIncluded()) {
                        if (null !== ($children = $element->getChildren()) && $element->isHighlightWithChildren()) {
                            $parsed .= $this->findElement($children);
                        } else {
                            $parsed .= htmlspecialchars($this->currentBlockEnd);
                            $this->pointer += $this->currentBlockEndLength;
                        }
                    }
                    $parsed .= '</span>';
                }
            }

            if (null !== $parsed) {
                break;
            }
        }

        return $parsed;
    }

    /**
     * @todo: merge the three methods below
     *
     * @param Key $element
     * @param $code
     * @return bool
     */
    public function findKey(Key $element, $code)
    {
        if (null === $element->getPrefix() || $this->isValidPrefix($element->getPrefix(), $element->getPrefixLength())) {
            foreach ($element->getKeys() as $key) {
                $keyLength = strlen($key);
                if ($key == substr($code, 0, $keyLength)) {
                    if (null === $element->getSuffix() || $this->isValidSuffix($keyLength, $element->getSuffix(), $element->getSuffixLength())) {
                        $this->currentKey = $key;
                        $this->currentKeyLength = $keyLength;
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param Block $element
     * @param $code
     * @return bool
     */
    public function findBlockStart(Block $element, $code)
    {
        if (null === $element->getStartPrefix() || $this->isValidPrefix($element->getStartPrefix(), $element->getStartPrefixLength())) {
            foreach ($element->getStart() as $key) {
                $keyLength = strlen($key);
                if ($key == substr($code, 0, $keyLength)) {
                    if (null === $element->getStartSuffix() || $this->isValidSuffix($keyLength, $element->getStartSuffix(), $element->getStartSuffixLength())) {
                        $this->currentBlockStart = $key;
                        $this->currentBlockStartLength = $keyLength;
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param Block $element
     * @param $code
     * @return bool
     */
    public function findBlockEnd(Block $element, $code)
    {
        if (null === $element->getEndPrefix() || $this->isValidPrefix($element->getEndPrefix(), $element->getEndPrefixLength())) {
            foreach ($element->getEnd() as $key) {
                $keyLength = strlen($key);

                if ($key == substr($code, 0, $keyLength)) {
                    if (null === $element->getEndSuffix() || $this->isValidSuffix($keyLength, $element->getEndSuffix(), $element->getEndSuffixLength())) {
                        $this->currentBlockEnd = $key;
                        $this->currentBlockEndLength = $keyLength;
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Check if the provided char is valid for the current block
     *
     * @param Block $element
     * @param string $char
     * @return bool
     */
    public function isValidContains(Block $element, $char)
    {
        if (null === $element->getContains()) {
            return true;
        }

        return preg_match('/' . $element->getContains() . '/', $char);
    }

    /**
     * Validate given prefix
     *
     * @param string $prefix Prefix to validate against
     * @param int $prefixLength Length of the prefix
     * @return bool Whether given prefix is valid
     */
    protected function isValidPrefix($prefix, $prefixLength)
    {
        $code = null;
        if (0 != $this->pointer) {
            $code = substr($this->code, $this->pointer - $prefixLength, $prefixLength);
        }

        return (bool) preg_match('/' . $prefix . '/', $code);
    }

    /**
     * Validate a give suffix
     *
     * @param int $offset Pointer offset (usualy length of the key/start)
     * @param string $suffix Suffix to validate against
     * @param int $suffixLength Length of the suffix
     * @return bool Whether given suffix is valid
     */
    protected function isValidSuffix($offset, $suffix, $suffixLength)
    {
        $code = substr($this->code, $this->pointer + $offset, $suffixLength);
        return (bool) preg_match('/' . $suffix . '/', $code);
    }
}
