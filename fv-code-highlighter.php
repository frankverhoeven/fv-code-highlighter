<?php

declare(strict_types=1);

/**
 * Plugin Name: FV Code Highlighter
 * Description: Highlighter your code to look beautiful.
 * Plugin URI:  https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/
 * Author:      Frank Verhoeven
 * Author URI:  https://frankverhoeven.me/
 * Version:     2.2
 */

if (version_compare(phpversion(), '7.0', '<')) {
    die('Your PHP version is too low, please update to 7.1 or higher.');
}

use FvCodeHighlighter\Autoloader;
use FvCodeHighlighter\Bootstrap;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\ConfigProvider;
use FvCodeHighlighter\Container\Container;

final class FvCodeHighlighter
{
    public function __construct()
    {
        register_activation_hook(__FILE__, [static::class, 'activation']);
        register_deactivation_hook(__FILE__, [static::class, 'deactivation']);
    }

    private function setupAutoloader()
    {
        require_once __DIR__ . '/src/Autoloader.php';

        $autoloader = new Autoloader(['FvCodeHighlighter' => __DIR__ . '/src/']);
        $autoloader->register();
    }

    public function start()
    {
        $this->setupAutoloader();

        $config = (new ConfigProvider())();

        $services                = $config['services'];
        $services[Config::class] = new Config($config['defaults']);

        $bootstrap = new Bootstrap(new Container($services));
        $bootstrap->bootstrap();
    }

    public static function activation()
    {
        do_action('fvch_activation');
        register_uninstall_hook(__FILE__, [static::class, 'uninstall']);
    }

    public static function deactivation()
    {
        do_action('fvch_deactivation');
    }

    public static function uninstall()
    {
        do_action('fvch_uninstall');
    }
}


$fvch = new \FvCodeHighlighter();
$fvch->start();


/**
 *  Q.E.D.
 */
