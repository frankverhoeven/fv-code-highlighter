<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter\Admin\Admin;
use FvCodeHighlighter\Cache\Cache;
use FvCodeHighlighter\Cache\Filesystem;
use FvCodeHighlighter\Cache\HashGenerator;
use FvCodeHighlighter\Container\AliasedFactory;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Container\Factory\Admin\AdminFactory;
use FvCodeHighlighter\Container\Factory\Cache\FilesystemFactory;
use FvCodeHighlighter\Container\Factory\Diagnostics\CodeFactory;
use FvCodeHighlighter\Container\Factory\Hook\EnqueueScriptsFactory;
use FvCodeHighlighter\Container\Factory\Hook\HeaderFactory;
use FvCodeHighlighter\Container\Factory\Hook\HighlighterFactory;
use FvCodeHighlighter\Container\Factory\InstallerFactory;
use FvCodeHighlighter\Container\Factory\Output\Formatter\FormatterFactory;
use FvCodeHighlighter\Container\InvokableFactory;
use FvCodeHighlighter\Diagnostics\Code;
use FvCodeHighlighter\Filter\CleanBeforeParse;
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
use FvCodeHighlighter\Highlighter\LanguageMap;
use FvCodeHighlighter\Highlighter\Php\Factory as PhpHighlighterFactory;
use FvCodeHighlighter\Highlighter\Php\Php as PhpHighlighter;
use FvCodeHighlighter\Highlighter\Provider;
use FvCodeHighlighter\Highlighter\ProviderFactory;
use FvCodeHighlighter\Highlighter\Xml\Factory as XmlHighlighterFactory;
use FvCodeHighlighter\Highlighter\Xml\Xml as XmlHighlighter;
use FvCodeHighlighter\Hook\BlockHighlighter;
use FvCodeHighlighter\Hook\EnqueueScripts;
use FvCodeHighlighter\Hook\Header;
use FvCodeHighlighter\Hook\Highlighter;
use FvCodeHighlighter\Output\Formatter\Formatter;

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
     * @return string[]|Factory[]
     */
    private function getServices(): array
    {
        return [
            Admin::class                 => AdminFactory::class,
            BashHighlighter::class       => BashHighlighterFactory::class,
            Bootstrap::class             => Factory\BootstrapFactory::class,
            BlockHighlighter::class      => InvokableFactory::class,
            Cache::class                 => new AliasedFactory(Filesystem::class),
            CleanBeforeParse::class      => InvokableFactory::class,
            Code::class                  => CodeFactory::class,
            CssHighlighter::class        => CssHighlighterFactory::class,
            EnqueueScripts::class        => EnqueueScriptsFactory::class,
            Filesystem::class            => FilesystemFactory::class,
            GeneralHighlighter::class    => GeneralHighlighterFactory::class,
            HashGenerator::class         => InvokableFactory::class,
            Header::class                => HeaderFactory::class,
            Highlighter::class           => HighlighterFactory::class,
            Formatter::class             => FormatterFactory::class,
            HtmlHighlighter::class       => HtmlHighlighterFactory::class,
            Installer::class             => InstallerFactory::class,
            JavascriptHighlighter::class => JavascriptHighlighterFactory::class,
            LanguageMap::class           => InvokableFactory::class,
            PhpHighlighter::class        => PhpHighlighterFactory::class,
            Provider::class              => ProviderFactory::class,
            XmlHighlighter::class        => XmlHighlighterFactory::class,
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
