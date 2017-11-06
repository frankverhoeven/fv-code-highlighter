<?php

namespace FvCodeHighlighter\Filter;

/**
 * FilterInterface
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
interface FilterInterface
{
    /**
     * Filter the given value.
     *
     * @param string $value
     * @return string
     */
    public function filter($value);
}
