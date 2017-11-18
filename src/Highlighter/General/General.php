<?php

namespace FvCodeHighlighter\Highlighter\General;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;

/**
 * General
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class General extends AbstractHighlighter
{
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
}
