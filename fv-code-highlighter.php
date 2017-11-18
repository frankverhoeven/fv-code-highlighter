<?php

/**
 * Plugin Name: FV Code Highlighter
 * Description: Highlight your code, Dreamweaver style.
 * Plugin URI:  https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/
 * Author:      Frank Verhoeven
 * Author URI:  https://frankverhoeven.me/
 * Version:     2.0
 */

final class FvCodeHighlighter
{
    const VERSION = '2.0';

    /**
     * Setup the autoloader
     *
     * @version 20171113
     */
    private function setupAutoloader()
    {
        require_once __DIR__ . '/src/Autoloader.php';

        $autoloader = new \FvCodeHighlighter\AutoLoader(['FvCodeHighlighter' => __DIR__ . '/src/']);
        $autoloader->register();
    }

    /**
     * Start the application
     *
     * @version 20171113
     */
    public function start()
    {
        $this->setupAutoloader();

        $app = new \FvCodeHighlighter\Application\Application();
        $app->run();
    }
}


try {
    $fvch = new FvCodeHighlighter();
    $fvch->start();
} catch (Exception $e) {
    if (defined('WP_DEBUG') && true === WP_DEBUG) {
        printf('<h3>%s</h3><pre>%s</pre>', $e->getMessage(), $e->getTraceAsString());
    }

    error_log($e->getMessage() . PHP_EOL . $e->getTraceAsString());
}


/**
 *  Q.E.D.
 */
