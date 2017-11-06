<?php

namespace FvCodeHighlighter\Application;

use FvCodeHighlighter\Admin\Admin;
use FvCodeHighlighter\Container;
use FvCodeHighlighter\Installer;
use FvCodeHighlighter\Output;

/**
 * Bootstrap
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 * @version 20171106
 */
class Bootstrap
{
    /**
     * Run the installer if necessary.
     *
     * @version 20171103
     */
    public function initInstaller()
    {
        $installer = new Installer();

        if ($installer->isInstall()) {
            $installer->doInstall();
        } elseif ($installer->isUpdate()) {
            $installer->doUpdate();
            Container::getInstance()->getCache()->clear();
        }
    }

    /**
     * Plugin output
     *
     * @version 20171103
     */
    public function initOutput()
    {
        $output = new Output(Container::getInstance()->getOptions());

        // WordPress
        add_filter('the_content',           [$output, 'highlightCode'], 3);
        add_filter('comment_text',          [$output, 'highlightCode'], 3);
        // bbPress
        add_filter('bbp_get_topic_content', [$output, 'highlightCode'], 3);
        add_filter('bbp_get_reply_content', [$output, 'highlightCode'], 3);

        add_action('wp_enqueue_scripts',    [$output, 'enqueueScripts']);

        add_action('wp_head',               [$output, 'displayHead']);
    }

    /**
     * Admin area
     *
     * @version 20171103
     */
    protected function initAdmin()
    {
        if (!is_admin()) return;

        $admin = new Admin();

        add_action('admin_enqueue_scripts',	 [$admin, 'enqueueScripts']);
        add_action('admin_menu',            [$admin, 'adminMenu']);
    }
}
