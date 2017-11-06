<?php

namespace FvCodeHighlighter\Application;

/**
 * Application
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Application
{
    /**
     * Application constructor.
     *
     * @version 20171106
     */
    public function __construct()
    {}

    /**
     * Bootstrap the app
     *
     * @version 20171106
     */
    protected function bootstrap()
    {
        $bootstrap = new Bootstrap();

        $methods = get_class_methods($bootstrap);
        foreach ($methods as $method) {
            if (0 == strpos($method, 'init')) {
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
