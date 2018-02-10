<?php

namespace FvCodeHighlighter\Application;

use FvCodeHighlighter\Admin\Admin;
use FvCodeHighlighter\Cache;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Installer;
use FvCodeHighlighter\Options;
use FvCodeHighlighter\Output;

/**
 * Bootstrap
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Bootstrap
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
     * __construct()
     *
     * @param Options $options
     * @param Cache $cache
     * @param Container $container
     */
    public function __construct(Options $options, Cache $cache, Container $container)
    {
        $this->options = $options;
        $this->cache = $cache;
        $this->container = $container;
    }

    /**
     * Run the installer if necessary.
     *
     */
    public function initInstaller()
    {
        $installer = new Installer($this->options, $this->cache);

        $installer->hasUpdate();

        if ($installer->isInstall()) {
            $installer->install();
        } elseif ($installer->isUpdate()) {
            $installer->update();
        }
    }

    /**
     * Plugin output
     *
     */
    public function initOutput()
    {
        $highlighter = new Output\Highlighter($this->options, $this->cache, $this->container);

        // WordPress
        add_filter('the_content',           $highlighter, 3);
        add_filter('comment_text',          $highlighter, 3);
        // bbPress
        add_filter('bbp_get_topic_content', $highlighter, 3);
        add_filter('bbp_get_reply_content', $highlighter, 3);

        add_action('wp_enqueue_scripts',    new Output\Scripts($this->options));
        add_action('wp_head',               new Output\Header($this->options));
    }

    /**
     * Admin area
     *
     */
    public function initAdmin()
    {
        if (!is_admin()) return;

        $admin = new Admin($this->options);

        add_action('admin_enqueue_scripts',	 [$admin, 'enqueueScripts']);
        add_action('admin_menu',            [$admin, 'adminMenu']);
    }
}
