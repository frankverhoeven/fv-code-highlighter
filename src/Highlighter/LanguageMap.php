<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Highlighter\Bash\Bash;
use FvCodeHighlighter\Highlighter\Css\Css;
use FvCodeHighlighter\Highlighter\General\General;
use FvCodeHighlighter\Highlighter\Html\Html;
use FvCodeHighlighter\Highlighter\Javascript\Javascript;
use FvCodeHighlighter\Highlighter\Php\Php;
use FvCodeHighlighter\Highlighter\Xml\Xml;

final class LanguageMap
{
    const MAP = [
        Bash::class       => ['bash', 'sh'],
        Css::class        => ['css'],
        General::class    => [''],
        Html::class       => ['html', 'xhtml', 'htm'],
        Javascript::class => ['js', 'javascript'],
        Php::class        => ['php'],
        Xml::class        => ['xml'],
    ];

    public function highlighterClassForLanguage(string $language): string
    {
        foreach (self::MAP as $highlighter => $languages) {
            if (\in_array(\strtolower($language), $languages, true)) {
                return $highlighter;
            }
        }

        return General::class;
    }
}
