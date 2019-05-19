<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Html;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;
use FvCodeHighlighter\Highlighter\Css\Css;
use FvCodeHighlighter\Highlighter\Javascript\Javascript;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Html extends AbstractHighlighter
{
    /** @var Css */
    private $cssHighlighter;

    /** @var Javascript */
    private $javascriptHighlighter;

    /**
     * @param Block[]|Key[] $elements
     */
    public function __construct(array $elements, Css $cssHighlighter, Javascript $javascriptHighlighter)
    {
        $this->cssHighlighter        = $cssHighlighter;
        $this->javascriptHighlighter = $javascriptHighlighter;

        parent::__construct($elements);
    }

    public function postProcess(string $code): string
    {
        \preg_match_all(
            '/&lt;style(.*?)&gt;<\/span>(?<code>.*?)<span class="html-style-element">&lt;\/style&gt;/msi',
            $code,
            $cssCode
        );
        $count = \count($cssCode[0]);

        for ($i = 0; $i < $count; $i++) {
            $parsed = $this->cssHighlighter->highlight(\htmlspecialchars_decode(\strip_tags($cssCode['code'][$i])));
            $code   = \str_replace($cssCode['code'][$i], '<span class="css">' . $parsed . '</span>', $code);
        }

        \preg_match_all('/style=<span class="html-attribute">&quot;(?<code>.*?)&quot;<\/span>/msi', $code, $cssCode);
        $count = \count($cssCode[0]);

        for ($i = 0; $i < $count; $i++) {
            $parsed = $this->cssHighlighter->highlight(\htmlspecialchars_decode(\strip_tags($cssCode['code'][$i])));
            $code   = \str_replace($cssCode['code'][$i], '<span class="css">' . $parsed . '</span>', $code);
        }

        \preg_match_all(
            '/&lt;script(.*?)&gt;<\/span>(?<code>.*?)<span class="html-script-element">&lt;\/script&gt;/msi',
            $code,
            $jsCode
        );
        $count = \count($jsCode[0]);

        for ($i = 0; $i < $count; $i++) {
            $parsed = $this->javascriptHighlighter->highlight(
                \htmlspecialchars_decode(\strip_tags($jsCode['code'][$i]))
            );
            $code   = \str_replace($jsCode['code'][$i], '<span class="js">' . $parsed . '</span>', $code);
        }

        return $code;
    }
}
