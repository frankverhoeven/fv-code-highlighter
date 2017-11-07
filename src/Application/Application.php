<?php

namespace FvCodeHighlighter\Application;

use FvCodeHighlighter\Cache;
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
     * Application constructor.
     *
     * @param Options|null $options
     * @version 20171107
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
    }

    /**
     * Bootstrap the app
     *
     * @version 20171106
     */
    protected function bootstrap()
    {
        $bootstrap = new Bootstrap($this->options, $this->cache);

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
     * @version 20171106
     */
    public function run()
    {
        $this->bootstrap();
    }
}
