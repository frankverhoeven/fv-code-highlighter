<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

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

final class ConfigProvider
{
    /**
     * @return mixed[]
     */
    public function __invoke(): array
    {
        return [
            'services' => $this->getServices(),
            'defaults' => $this->getDefaults(),
        ];
    }

    /**
     * @return string[]
     */
    private function getServices(): array
    {
        return [
            BashHighlighter::class => BashHighlighterFactory::class,
            CssHighlighter::class => CssHighlighterFactory::class,
            GeneralHighlighter::class => GeneralHighlighterFactory::class,
            HtmlHighlighter::class => HtmlHighlighterFactory::class,
            JavascriptHighlighter::class => JavascriptHighlighterFactory::class,
            PhpHighlighter::class => PhpHighlighterFactory::class,
            XmlHighlighter::class => XmlHighlighterFactory::class,
        ];
    }

    /**
     * @return mixed[]
     */
    private function getDefaults(): array
    {
        return [
            /**
             * @var string Current plugin version.
             */
            'fvch_version' => Version::getCurrentVersion(),

            /**
             * @var string Cache directory.
             */
            'fvch-cache-dir' => \dirname(__DIR__) . '/cache',

            /**
             * @var string CSS font-family.
             */
            'fvch-font-family' => 'Monaco',

            /**
             * @var string CSS font-size (em)
             */
            'fvch-font-size' => '0.8',

            /**
             * @var string Background (notepaper, white, custom)
             */
            'fvch-background' => 'white',

            /**
             * @var string Custom CSS background-color.
             */
            'fvch-background-custom' => '#ffffff',

            /**
             * @var bool Whether to use line numbers.
             */
            'fvch-line-numbers' => true,

            /**
             * @var bool Whether to use the toolbox.
             */
            'fvch-toolbox' => false,

            /**
             * @var bool Whether to use dark mode.
             */
            'fvch-dark-mode' => true,

            /**
             * @var bool Whether to enable diagnostics.
             */
            'fvch-diagnostics' => true,
        ];
    }
}
