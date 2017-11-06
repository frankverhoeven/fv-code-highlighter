<?php

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Container;

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
     * __construct()
     *
     */
	public function __construct()
	{}

    /**
     * Enqueue scripts/styles.
     *
     * @param string $hook Current page hook
     * @return void
     */
	public function enqueueScripts($hook)
	{
        if ($this->optionsPageHook != $hook) return;

        wp_register_style('fvch-admin-css', plugins_url('public/css/admin.css', dirname(__FILE__)), false, '1.0');
        wp_enqueue_style('fvch-admin-css');
        wp_enqueue_style('farbtastic');

        wp_enqueue_script('fvch-admin-js', plugins_url('public/js/admin.js', dirname(__FILE__)), ['jquery', 'farbtastic'], '1.0');
	}

    /**
     * Add admin pages to the menu.
     *
     */
	public function adminMenu()
	{
		$this->optionsPageHook = add_theme_page(
			__('FV Code AbstractHighlighter Options', 'fvch'),
			__('Code AbstractHighlighter', 'fvch'),
			'edit_themes',
			'fvch-options',
			[$this, 'optionsPage']
		);
	}

    /**
     * Display the admin page.
     *
     */
    public function optionsPage()
    {
        $optionsPage = new Options(Container::getInstance()->getOptions());

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $optionsPage->updateOptions();
        }

        $optionsPage->displayOptions();
    }
}
