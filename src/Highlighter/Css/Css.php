<?php

namespace FvCodeHighlighter\Highlighter\Css;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;

/**
 * Css
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Css extends AbstractHighlighter
{
    /**
     * @var array List of all CSS Properties (stripped for performance)
     */
    public static $properties = [
        '@font-',
        '@keyframes',
        'align-',
        'animation',
        'backface-visibility',
        'background',
        'border',
        'bottom',
        'box-',
        'break-',
        'caption-side',
        'clear',
        'clip',
        'color',
        'column-',
        'columns',
        'content',
        'counter-',
        'cursor',
        'direction',
        'display',
        'empty-cells',
        'filter',
        'flex',
        'float',
        'font',
        'hanging-punctuation',
        'height',
        'hyphens',
        'image-',
        'ime-mode',
        'justify-content',
        'left',
        'letter-spacing',
        'line-',
        'margin',
        'mark',
        'mask',
        'max-',
        'min-',
        'object-',
        'opacity',
        'order',
        'orphans',
        'outline',
        'overflow',
        'padding',
        'page-break-',
        'perspective',
        'phonemes',
        'position',
        'quotes',
        'resize',
        'rest',
        'right',
        'tab-size',
        'table-layout',
        'text-',
        'top',
        'transform',
        'transition',
        'unicode-bidi',
        'user-select',
        'vertical-align',
        'visibility',
        'voice-',
        'white-space',
        'widows',
        'width',
        'word-',
        'writing-mode',
        'z-index',
        '-moz-',
        '-webkit-',
        '-o-',
        '-ms-',
    ];

    public function postProcess($code)
    {
        // Fixes
        $code = str_replace(':<span class="css-value">', '<span class="css-selector">:</span><span class="css-value">', $code);
        $code = preg_replace('/\}(\s*?)\}/', '}\\1<span class="css-media">}</span>', $code);

        return $code;
    }

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
}
