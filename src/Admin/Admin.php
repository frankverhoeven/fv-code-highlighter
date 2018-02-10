<?php

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Options as PluginOptions;

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
     * @var PluginOptions
     */
    private $options;

    /**
     * __construct()
     *
     * @param PluginOptions $options
     */
	public function __construct(PluginOptions $options)
	{
        $this->options = $options;
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

        wp_register_style('fvch-admin-css', plugins_url('public/css/admin.min.css', dirname(__FILE__, 2)), false, '1.1');
        wp_enqueue_style('fvch-admin-css');
        wp_enqueue_style('farbtastic');

        wp_enqueue_script('fvch-admin-js', plugins_url('public/js/admin.min.js', dirname(__FILE__, 2)), ['jquery', 'farbtastic'], '1.0');
	}

    /**
     * Add admin pages to the menu.
     *
     */
	public function adminMenu()
	{
		$this->optionsPageHook = add_theme_page(
			__('FV Code Highlighter Options', 'fvch'),
			__('Code Highlighter', 'fvch'),
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
        $optionsPage = new Options($this->options);

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $optionsPage->updateOptions();
        }

        $optionsPage->displayOptions();
    }
}
