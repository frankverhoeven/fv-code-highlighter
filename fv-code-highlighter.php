<?php

declare(strict_types=1);

// phpcs:disable PSR1.Files.SideEffects
// phpcs:disable Squiz.Classes.ClassFileName

namespace FvCodeHighlighter;

/**
 * Plugin Name: FV Code Highlighter
 * Description: Highlighter your code to look beautiful.
 * Plugin URI:  https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/
 * Author:      Frank Verhoeven
 * Author URI:  https://frankverhoeven.me/
 * Version:     2.2.1
 */

if (\PHP_VERSION_ID < 70000) {
    die('Your PHP version is to low, please upgrade to 7.0 or higher.');
}

use FvCodeHighlighter\Container\Container;

/** @noinspection AutoloadingIssuesInspection */
final class FvCodeHighlighter
{
    public function __construct()
    {
        \register_activation_hook(__FILE__, [self::class, 'activation']);
        \register_deactivation_hook(__FILE__, [self::class, 'deactivation']);
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

        $container = new Container($services);
        $container->get(Bootstrap::class)->bootstrap();
    }

    public static function activation()
    {
        \do_action('fvch_activation');
        \register_uninstall_hook(__FILE__, [self::class, 'uninstall']);
    }

    public static function deactivation()
    {
        \do_action('fvch_deactivation');
    }

    public static function uninstall()
    {
        \do_action('fvch_uninstall');
    }
}


$fvch = new FvCodeHighlighter();
$fvch->start();


/**
 *  Q.E.D.
 */
