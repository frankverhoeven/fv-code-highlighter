<?php

namespace FvCodeHighlighter\Parser\Element;

/**
 * Block
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Block
{
    /**
     * @var array
     */
    private $start;
    /**
     * @var bool
     */
    private $startIncluded = true;
    /**
     * @var string
     */
    private $startPrefix;
    /**
     * @var int
     */
    private $startPrefixLength = 1;
    /**
     * @var string
     */
    private $startSuffix;
    /**
     * @var int
     */
    private $startSuffixLength = 1;
    /**
     * @var array
     */
    private $end;
    /**
     * @var bool
     */
    private $endIncluded = true;
    /**
     * @var string
     */
    private $endPrefix;
    /**
     * @var int
     */
    private $endPrefixLength = 1;
    /**
     * @var string
     */
    private $endSuffix;
    /**
     * @var int
     */
    private $endSuffixLength = 1;
    /**
     * @var string
     */
    private $cssClass;
    /**
     * @var Key[]|Block[]
     */
    private $children;
    /**
     * @var bool
     */
    private $highlightWithChildren = false;

    /**
     * __construct()
     *
     * @param array $options
     */
    private function __construct(array $options)
    {
        $methods = get_class_methods($this);
        $keys = array_keys($options);

        foreach ($keys as $name) {
            if (in_array('get' . ucfirst($name), $methods) || in_array('is' . ucfirst($name), $methods)) {
                $this->{$name} = $options[$name];
            }
        }
    }

    /**
     * Create a new block element
     *
     * @param array $options
     * @return Block
     */
    public static function create(array $options)
    {
        return new static($options);
    }

    /**
     * @return array
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return bool
     */
    public function isStartIncluded()
    {
        return $this->startIncluded;
    }

    /**
     * @return string
     */
    public function getStartPrefix()
    {
        return $this->startPrefix;
    }

    /**
     * @return int
     */
    public function getStartPrefixLength()
    {
        return $this->startPrefixLength;
    }

    /**
     * @return string
     */
    public function getStartSuffix()
    {
        return $this->startSuffix;
    }

    /**
     * @return int
     */
    public function getStartSuffixLength()
    {
        return $this->startSuffixLength;
    }

    /**
     * @return array
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return bool
     */
    public function isEndIncluded()
    {
        return $this->endIncluded;
    }

    /**
     * @return string
     */
    public function getEndPrefix()
    {
        return $this->endPrefix;
    }

    /**
     * @return int
     */
    public function getEndPrefixLength()
    {
        return $this->endPrefixLength;
    }

    /**
     * @return string
     */
    public function getEndSuffix()
    {
        return $this->endSuffix;
    }

    /**
     * @return int
     */
    public function getEndSuffixLength()
    {
        return $this->endSuffixLength;
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @return Block[]|Key[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function isHighlightWithChildren()
    {
        return $this->highlightWithChildren;
    }
}
