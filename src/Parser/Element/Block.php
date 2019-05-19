<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser\Element;

final class Block
{
    /** @var string[] */
    private $start;

    /** @var bool */
    private $startIncluded = true;

    /** @var string|null */
    private $startPrefix;

    /** @var int */
    private $startPrefixLength = 1;

    /** @var string|null */
    private $startSuffix;

    /** @var int */
    private $startSuffixLength = 1;

    /** @var string[] */
    private $end;

    /** @var bool */
    private $endIncluded = true;

    /** @var string|null */
    private $endPrefix;

    /** @var int */
    private $endPrefixLength = 1;

    /** @var string|null */
    private $endSuffix;

    /** @var int */
    private $endSuffixLength = 1;

    /** @var string|null */
    private $contains;

    /** @var string */
    private $cssClass;

    /** @var Key[]|Block[]|null */
    private $children;

    /** @var bool */
    private $highlightWithChildren = false;

    /**
     * @param mixed[] $options
     */
    private function __construct(array $options)
    {
        $keys = \array_keys($options);

        foreach ($keys as $name) {
            $this->{$name} = $options[$name];
        }
    }

    /**
     * @param mixed[] $options
     */
    public static function create(array $options): Block
    {
        return new static($options);
    }

    /**
     * @return string[]
     */
    public function start(): array
    {
        return $this->start;
    }

    public function isStartIncluded(): bool
    {
        return $this->startIncluded;
    }

    /**
     * @return string|null
     */
    public function startPrefix()
    {
        return $this->startPrefix;
    }

    public function hasStartPrefix(): bool
    {
        return $this->startPrefix !== null;
    }

    public function startPrefixLength(): int
    {
        return $this->startPrefixLength;
    }

    /**
     * @return string|null
     */
    public function startSuffix()
    {
        return $this->startSuffix;
    }

    public function hasStartSuffix(): bool
    {
        return $this->startSuffix !== null;
    }

    public function startSuffixLength(): int
    {
        return $this->startSuffixLength;
    }

    /**
     * @return string[]
     */
    public function end(): array
    {
        return $this->end;
    }

    public function isEndIncluded(): bool
    {
        return $this->endIncluded;
    }

    /**
     * @return string|null
     */
    public function endPrefix()
    {
        return $this->endPrefix;
    }

    public function hasEndPrefix(): bool
    {
        return $this->endPrefix !== null;
    }

    public function endPrefixLength(): int
    {
        return $this->endPrefixLength;
    }

    /**
     * @return string|null
     */
    public function endSuffix()
    {
        return $this->endSuffix;
    }

    public function hasEndSuffix(): bool
    {
        return $this->endSuffix !== null;
    }

    public function endSuffixLength(): int
    {
        return $this->endSuffixLength;
    }

    /**
     * @return string|null
     */
    public function contains()
    {
        return $this->contains;
    }

    public function hasContains(): bool
    {
        return $this->contains !== null;
    }

    public function cssClass(): string
    {
        return $this->cssClass;
    }

    /**
     * @return Block[]|Key[]|null
     */
    public function children()
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return $this->children !== null;
    }

    public function isHighlightWithChildren(): bool
    {
        return $this->highlightWithChildren;
    }
}
