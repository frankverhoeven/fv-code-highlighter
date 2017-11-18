<?php

namespace FvCodeHighlighter\Highlighter\Xml;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;

/**
 * Xml
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Xml extends AbstractHighlighter
{
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
}
