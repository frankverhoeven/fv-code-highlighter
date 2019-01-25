<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Config;

final class Admin
{
    /** @var Config */
    private $config;

    /** @var string */
    private $pageHook;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function enqueueScripts(string $hook)
    {
        if ($this->pageHook !== $hook) {
            return;
        }

        \wp_register_style('fvch-admin-css', \plugins_url('public/css/admin.min.css', \dirname(__FILE__, 2)), false, '1.1');
        \wp_enqueue_style('fvch-admin-css');
        \wp_enqueue_style('farbtastic');

        \wp_enqueue_script('fvch-admin-js', \plugins_url('public/js/admin.min.js', \dirname(__FILE__, 2)), ['jquery', 'farbtastic'], '1.0');
    }

    public function adminMenu()
    {
        $this->pageHook = \add_theme_page(
            \__('FV Code Highlighter Options', 'fvch'),
            \__('Code Highlighter', 'fvch'),
            'edit_themes',
            'fvch-options',
            [new Options($this->config), 'page']
        );
    }
}
