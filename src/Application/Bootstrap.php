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
     * @version 20171118
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
     * @version 20171107
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
     * @version 20171118
     */
    public function initOutput()
    {
        $output = new Output($this->options, $this->cache, $this->container);

        // WordPress
        add_filter('the_content',           [$output, 'highlightCode'], 3);
        add_filter('comment_text',          [$output, 'highlightCode'], 3);
        // bbPress
        add_filter('bbp_get_topic_content', [$output, 'highlightCode'], 3);
        add_filter('bbp_get_reply_content', [$output, 'highlightCode'], 3);

        add_action('wp_enqueue_scripts',    [$output, 'enqueueScripts']);

        add_action('wp_head',               [$output, 'displayHead']);
        add_action('wp_footer',             [$output, 'displayFooter']);
    }

    /**
     * Admin area
     *
     * @version 20171103
     */
    public function initAdmin()
    {
        if (!is_admin()) return;

        $admin = new Admin($this->options);

        add_action('admin_enqueue_scripts',	 [$admin, 'enqueueScripts']);
        add_action('admin_menu',            [$admin, 'adminMenu']);
    }
}
