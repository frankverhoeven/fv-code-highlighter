<?php

namespace FvCodeHighlighter\Highlighter\Html;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;
use FvCodeHighlighter\Highlighter\Css\Css;
use FvCodeHighlighter\Highlighter\Javascript\Javascript;

/**
 * Php
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Html extends AbstractHighlighter
{
    /**
     * @var Css
     */
    private $cssHighlighter;
    /**
     * @var Javascript
     */
    private $javascriptHighlighter;

    /**
     * @param string $code
     * @return string
     */
    public function postProcess($code)
    {
        \preg_match_all('/&lt;style(.*?)&gt;<\/span>(?<code>.*?)<span class="html-style-element">&lt;\/style&gt;/msi', $code, $cssCode);
        for ($i=0; $i<\count($cssCode[0]); $i++) {
            $parsed = $this->cssHighlighter->highlight(\htmlspecialchars_decode(\strip_tags($cssCode['code'][$i])));
            $code = \str_replace($cssCode['code'][$i], '<span class="css">' . $parsed . '</span>', $code);
        }
        \preg_match_all('/style=<span class="html-attribute">&quot;(?<code>.*?)&quot;<\/span>/msi', $code, $cssCode);
        for ($i=0; $i<\count($cssCode[0]); $i++) {
            $parsed = $this->cssHighlighter->highlight(\htmlspecialchars_decode(\strip_tags($cssCode['code'][$i])));
            $code = \str_replace($cssCode['code'][$i], '<span class="css">' . $parsed . '</span>', $code);
        }

        \preg_match_all('/&lt;script(.*?)&gt;<\/span>(?<code>.*?)<span class="html-script-element">&lt;\/script&gt;/msi', $code, $jsCode);
        for ($i=0; $i<\count($jsCode[0]); $i++) {
            $parsed = $this->javascriptHighlighter->highlight(\htmlspecialchars_decode(\strip_tags($jsCode['code'][$i])));
            $code = \str_replace($jsCode['code'][$i], '<span class="js">' . $parsed . '</span>', $code);
        }

        return $code;
    }

    /**
     * __construct()
     *
     * @param array $elements
     * @param Css $cssHighlighter
     * @param Javascript $javascriptHighlighter
     */
    public function __construct(array $elements, Css $cssHighlighter, Javascript $javascriptHighlighter)
    {
        $this->elements = $elements;
        $this->cssHighlighter = $cssHighlighter;
        $this->javascriptHighlighter = $javascriptHighlighter;
    }
}
