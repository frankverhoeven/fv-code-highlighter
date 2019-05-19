<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Config;

final class Admin
{
    /** @var Config */
    private $config;

    /** @var string */
    private $optionsPageHook;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Enqueue scripts/styles.
     *
     * @param string $hook Current page hook
     */
    public function enqueueScripts(string $hook)
    {
        if ($hook === 'post.php') {
            \wp_enqueue_script(
                'language-select',
                \plugins_url('public/js/gutenberg.js', \dirname(__FILE__, 2)),
                [
                    'wp-i18n',
                    'wp-hooks',
                    'wp-compose',
                    'wp-element',
                    'wp-editor',
                    'wp-components',
                ],
                '1.0',
                true
            );
        }

        if ($this->optionsPageHook !== $hook) {
            return;
        }

        \wp_register_style(
            'fvch-admin-css',
            \plugins_url('public/css/admin.min.css', \dirname(__FILE__, 2)),
            false,
            '1.1'
        );
        \wp_enqueue_style('fvch-admin-css');
        \wp_enqueue_style('farbtastic');

        \wp_enqueue_script(
            'fvch-admin-js',
            \plugins_url('public/js/admin.min.js', \dirname(__FILE__, 2)),
            ['jquery', 'farbtastic'],
            '1.0',
            true
        );
    }

    public function adminMenu()
    {
        $this->optionsPageHook = \add_theme_page(
            \__('FV Code Highlighter Options', 'fvch'),
            \__('Code Highlighter', 'fvch'),
            'edit_themes',
            'fvch-options',
            [new Options($this->config), 'page']
        );
    }
}
