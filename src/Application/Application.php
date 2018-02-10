<?php

namespace FvCodeHighlighter\Application;

use FvCodeHighlighter\Cache;
use FvCodeHighlighter\Container\Container;
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
use FvCodeHighlighter\Options;

/**
 * Application
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Application
{
    /**
     * @var Options
     */
    private $options;
    /**
     * @var Cache
     */
    private $cache;
    /**
     * @var Container
     */
    private $container;

    /**
     * Application constructor.
     *
     * @param Options|null $options
     */
    public function __construct(Options $options = null)
    {
        if (null === $options) {
            $options = new Options();
        }
        $cacheDir = $options->getOption('fvch-cache-dir');
        if ('' == $cacheDir || !is_dir($cacheDir)) {
            $cacheDir = $options->getDefaultOption('fvch-cache-dir');
        }

        $this->cache = new Cache($cacheDir);
        $this->options = $options;
        $this->container = new Container([
            BashHighlighter::class => BashHighlighterFactory::class,
            CssHighlighter::class => CssHighlighterFactory::class,
            GeneralHighlighter::class => GeneralHighlighterFactory::class,
            HtmlHighlighter::class => HtmlHighlighterFactory::class,
            JavascriptHighlighter::class => JavascriptHighlighterFactory::class,
            PhpHighlighter::class => PhpHighlighterFactory::class,
            XmlHighlighter::class => XmlHighlighterFactory::class,
        ]);
    }

    /**
     * Bootstrap the app
     *
     */
    protected function bootstrap()
    {
        $bootstrap = new Bootstrap($this->options, $this->cache, $this->container);

        $methods = get_class_methods($bootstrap);
        foreach ($methods as $method) {
            if (0 === strpos($method, 'init')) {
                $bootstrap->$method();
            }
        }
    }

    /**
     * Run the application
     *
     */
    public function run()
    {
        $this->bootstrap();
    }
}
