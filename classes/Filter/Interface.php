<?php

/**
 * FvCodeHighlighter_Filter_Interface
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
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
