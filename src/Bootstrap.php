<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter\Admin\Admin;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Hook\BlockHighlighter;
use FvCodeHighlighter\Hook\EnqueueScripts;
use FvCodeHighlighter\Hook\Header;
use FvCodeHighlighter\Hook\Highlighter;

final class Bootstrap
{
    /** @var BlockHighlighter */
    private $blockHighlighter;

    /** @var Container */
    private $container;

    /** @var EnqueueScripts */
    private $enqueueScripts;

    /** @var Header */
    private $header;

    /** @var Highlighter */
    private $highlighter;

    /** @var Installer */
    private $installer;

    public function __construct(
        BlockHighlighter $blockHighlighter,
        Container $container,
        EnqueueScripts $enqueueScripts,
        Header $header,
        Highlighter $highlighter,
        Installer $installer
    ) {
        $this->blockHighlighter = $blockHighlighter;
        $this->container        = $container;
        $this->enqueueScripts   = $enqueueScripts;
        $this->header           = $header;
        $this->highlighter      = $highlighter;
        $this->installer        = $installer;
    }

    public function bootstrap()
    {
        $this->initInstaller();
        $this->initOutput();
        $this->initAdmin();
    }

    public function initInstaller()
    {
        $this->installer->hasUpdate();

        if ($this->installer->isInstall()) {
            $this->installer->install();
        } elseif ($this->installer->isUpdate()) {
            $this->installer->update();
        }
    }

    public function initOutput()
    {
        \add_filter('render_block', $this->blockHighlighter, 10, 2);

        // WordPress
        \add_filter('the_content', $this->highlighter, 9);
        \add_filter('comment_text', $this->highlighter, 9);
        // bbPress
        \add_filter('bbp_get_topic_content', $this->highlighter, 9);
        \add_filter('bbp_get_reply_content', $this->highlighter, 9);

        \add_action('wp_enqueue_scripts', $this->enqueueScripts);
        \add_action('wp_head', $this->header);
    }

    public function initAdmin()
    {
        if (!\is_admin()) {
            return;
        }

        $admin = $this->container->get(Admin::class);

        \add_action('admin_enqueue_scripts', [$admin, 'enqueueScripts']);
        \add_action('admin_menu', [$admin, 'adminMenu']);
    }
}
