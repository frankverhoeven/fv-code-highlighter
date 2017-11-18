<?php

namespace FvCodeHighlighter\Parser\Element;

/**
 * Key
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Key
{
    /**
     * @var string[]
     */
    private $keys;
    /**
     * @var string Regex that must match char(s) before $key
     */
    private $prefix;
    /**
     * @var int
     */
    private $prefixLength = 1;
    /**
     * @var string Regex that must match char(s) after $key
     */
    private $suffix;
    /**
     * @var int
     */
    private $suffixLength = 1;
    /**
     * @var string
     */
    private $cssClass;

    /**
     * __construct()
     *
     * @param string[] $keys
     * @param string $cssClass
     * @param string $prefix
     * @param string $suffix
     * @param int $prefixLength
     * @param int $suffixLength
     */
    private function __construct(array $keys, $cssClass, $prefix = null, $suffix = null, $prefixLength = null, $suffixLength = null)
    {
        $this->keys = $keys;
        $this->cssClass = $cssClass;
        $this->prefix = $prefix;
        $this->suffix = $suffix;

        if (null !== $prefixLength) {
            $this->prefixLength = $prefixLength;
        }
        if (null !== $suffixLength) {
            $this->suffixLength = $suffixLength;
        }
    }

    /**
     * Create a new key
     *
     * @param string[] $keys
     * @param string $cssClass
     * @param string $prefix
     * @param string $suffix
     * @param int $prefixLength
     * @param int $suffixLength
     * @return Key
     */
    public static function create(array $keys, $cssClass, $prefix = null, $suffix = null, $prefixLength = null, $suffixLength = null)
    {
        return new static($keys, $cssClass, $prefix, $suffix, $prefixLength, $suffixLength);
    }

    /**
     * @return string[]
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return int
     */
    public function getPrefixLength()
    {
        return $this->prefixLength;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @return int
     */
    public function getSuffixLength()
    {
        return $this->suffixLength;
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }
}
