<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser\Element;

final class Key
{
    /** @var string[] */
    private $keys;

    /** @var string|null Regex that must match char(s) before $key */
    private $prefix;

    /** @var int */
    private $prefixLength;

    /** @var string|null Regex that must match char(s) after $key */
    private $suffix;

    /** @var int */
    private $suffixLength;

    /** @var string */
    private $cssClass;

    /**
     * @param string[] $keys
     */
    private function __construct(
        array $keys,
        string $cssClass,
        string $prefix = null,
        string $suffix = null,
        int $prefixLength = null,
        int $suffixLength = null
    ) {
        $this->keys     = $keys;
        $this->cssClass = $cssClass;
        $this->prefix   = $prefix;
        $this->suffix   = $suffix;

        $this->prefixLength = $prefixLength ?? 1;
        $this->suffixLength = $suffixLength ?? 1;
    }

    /**
     * Create a new key
     *
     * @param string[] $keys
     */
    public static function create(
        array $keys,
        string $cssClass,
        string $prefix = null,
        string $suffix = null,
        int $prefixLength = null,
        int $suffixLength = null
    ): Key {
        return new static(
            $keys,
            $cssClass,
            $prefix,
            $suffix,
            $prefixLength,
            $suffixLength
        );
    }

    /**
     * @return string[]
     */
    public function keys(): array
    {
        return $this->keys;
    }

    /**
     * @return string|null
     */
    public function prefix()
    {
        return $this->prefix;
    }

    public function hasPrefix(): bool
    {
        return $this->prefix !== null;
    }

    public function prefixLength(): int
    {
        return $this->prefixLength;
    }

    /**
     * @return string|null
     */
    public function suffix()
    {
        return $this->suffix;
    }

    public function hasSuffix(): bool
    {
        return $this->suffix !== null;
    }

    public function suffixLength(): int
    {
        return $this->suffixLength;
    }

    public function cssClass(): string
    {
        return $this->cssClass;
    }
}
