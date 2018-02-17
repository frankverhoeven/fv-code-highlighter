<?php

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Config;

/**
 * FvCodeHighlighter_Admin
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Admin
{
    /**
     * @var string
     */
    protected $optionsPageHook;
    /**
     * @var Config
     */
    private $config;

    /**
     * __construct()
     *
     * @param Config $config
     */
	public function __construct(Config $config)
	{
        $this->config = $config;
    }

    /**
     * Enqueue scripts/styles.
     *
     * @param string $hook Current page hook
     * @return void
     */
	public function enqueueScripts($hook)
	{
        if ($this->optionsPageHook != $hook) return;

        \wp_register_style('fvch-admin-css', \plugins_url('public/css/admin.min.css', \dirname(__FILE__, 2)), false, '1.1');
        \wp_enqueue_style('fvch-admin-css');
        \wp_enqueue_style('farbtastic');

        \wp_enqueue_script('fvch-admin-js', \plugins_url('public/js/admin.min.js', \dirname(__FILE__, 2)), ['jquery', 'farbtastic'], '1.0');
	}

    /**
     * Add admin pages to the menu.
     *
     */
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
