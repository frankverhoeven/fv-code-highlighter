<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter\Admin\Admin;
use FvCodeHighlighter\Container\Container;

final class Bootstrap
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        $this->setupCache();
        $this->initInstaller();
        $this->initOutput();
        $this->initAdmin();
    }

    private function setupCache()
    {
        $cacheDir = $this->container->get(Config::class)['fvch-cache-dir'];
        if ($cacheDir === '' || ! \is_dir($cacheDir)) {
            $cacheDir = $this->container->get(Config::class)->getDefault('fvch-cache-dir');
        }

        $this->container->add(Cache::class, new Cache($cacheDir));
    }

    public function initInstaller()
    {
        $installer = new Installer(
            $this->container->get(Config::class),
            $this->container->get(Cache::class)
        );

        $installer->hasUpdate();

        if ($installer->isInstall()) {
            $installer->install();
        } elseif ($installer->isUpdate()) {
            $installer->update();
        }
    }

    public function initOutput()
    {
        $highlighter = new Output\Highlighter(
            $this->container->get(Config::class),
            $this->container->get(Cache::class),
            $this->container
        );

        // WordPress
        \add_filter('the_content', $highlighter, 3);
        \add_filter('comment_text', $highlighter, 3);
        // bbPress
        \add_filter('bbp_get_topic_content', $highlighter, 3);
        \add_filter('bbp_get_reply_content', $highlighter, 3);

        \add_action('wp_enqueue_scripts', new Output\Scripts($this->container->get(Config::class)));
        \add_action('wp_head', new Output\Header($this->container->get(Config::class)));
    }

    public function initAdmin()
    {
        if (! \is_admin()) {
            return;
        }

        $admin = new Admin($this->container->get(Config::class));

        \add_action('admin_enqueue_scripts', [$admin, 'enqueueScripts']);
        \add_action('admin_menu', [$admin, 'adminMenu']);
    }
}
