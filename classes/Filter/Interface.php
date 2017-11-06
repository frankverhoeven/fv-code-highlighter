<?php

/**
 * FvCodeHighlighter_Filter_Interface
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
interface FvCodeHighlighter_Filter_Interface
{
    /**
     * Filter the given value.
     *
     * @param string $value
     * @return string
     */
    public function filter($value);
}
