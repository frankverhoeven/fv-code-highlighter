<?php

/**
 * Plugin Name: FV Code Highlighter
 * Description: Highlighter your code to look beautiful.
 * Plugin URI:  https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/
 * Author:      Frank Verhoeven
 * Author URI:  https://frankverhoeven.me/
 * Version:     2.1
 */

use FvCodeHighlighter\AutoLoader;
use FvCodeHighlighter\Bootstrap;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;

final class FvCodeHighlighter
{
    /**
     * Register activation/deactivation hooks.
     *
     */
    public function __construct()
    {
        \register_activation_hook(__FILE__, [static::class, 'activation']);
        \register_deactivation_hook(__FILE__, [static::class, 'deactivation']);
    }

    /**
     * Setup the autoloader
     *
     */
    private function setupAutoloader()
    {
        require_once __DIR__ . '/src/Autoloader.php';

        $autoloader = new AutoLoader(['FvCodeHighlighter' => __DIR__ . '/src/']);
        $autoloader->register();
    }

    /**
     * Start the application
     *
     */
    public function start()
    {
        $this->setupAutoloader();

        $services = include __DIR__ . '/config/service.config.php';
        $services[Config::class] = new Config(include __DIR__ . '/config/default.config.php');

        $bootstrap = new Bootstrap(new Container($services));
        $bootstrap->bootstrap();
    }

    /**
     * Activation Hook
     *
     * @return void
     */
    public static function activation(): void
    {
        \do_action('fvch_activation');
        \register_uninstall_hook(__FILE__, [static::class, 'uninstall']);
    }

    /**
     * Deactivation Hook
     *
     * @return void
     */
    public static function deactivation(): void
    {
        \do_action('fvch_deactivation');
    }

    /**
     * Uninstall Hook
     *
     * @return void
     */
    public static function uninstall(): void
    {
        \do_action('fvch_uninstall');
    }
}


try {
    $fvch = new \FvCodeHighlighter();
    $fvch->start();
} catch (\Exception $e) {
    if (\defined('WP_DEBUG') && true === WP_DEBUG) {
        \printf('<h3>%s</h3><pre>%s</pre>', $e->getMessage(), $e->getTraceAsString());
    }

    \error_log($e->getMessage() . PHP_EOL . $e->getTraceAsString());
}


/**
 *  Q.E.D.
 */
