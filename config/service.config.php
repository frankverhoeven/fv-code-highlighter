<?php

use FvCodeHighlighter\Highlighter\Bash\Bash as BashHighlighter;
use FvCodeHighlighter\Highlighter\Bash\Factory as BashHighlighterFactory;
use FvCodeHighlighter\Highlighter\Css\Css as CssHighlighter;
use FvCodeHighlighter\Highlighter\Css\Factory as CssHighlighterFactory;
use FvCodeHighlighter\Highlighter\General\Factory as GeneralHighlighterFactory;
use FvCodeHighlighter\Highlighter\General\General as GeneralHighlighter;
use FvCodeHighlighter\Highlighter\Html\Factory as HtmlHighlighterFactory;
use FvCodeHighlighter\Highlighter\Html\Html as HtmlHighlighter;
use FvCodeHighlighter\Highlighter\Javascript\Factory as JavascriptHighlighterFactory;
use FvCodeHighlighter\Highlighter\Javascript\Javascript as JavascriptHighlighter;
use FvCodeHighlighter\Highlighter\Php\Factory as PhpHighlighterFactory;
use FvCodeHighlighter\Highlighter\Php\Php as PhpHighlighter;
use FvCodeHighlighter\Highlighter\Xml\Factory as XmlHighlighterFactory;
use FvCodeHighlighter\Highlighter\Xml\Xml as XmlHighlighter;

return [
    BashHighlighter::class => BashHighlighterFactory::class,
    CssHighlighter::class => CssHighlighterFactory::class,
    GeneralHighlighter::class => GeneralHighlighterFactory::class,
    HtmlHighlighter::class => HtmlHighlighterFactory::class,
    JavascriptHighlighter::class => JavascriptHighlighterFactory::class,
    PhpHighlighter::class => PhpHighlighterFactory::class,
    XmlHighlighter::class => XmlHighlighterFactory::class,
];
