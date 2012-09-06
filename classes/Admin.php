<?php

/**
 * FvCodeHighlighter_Admin
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Admin
{
    /**
     * Options Page Hook
     * @var string
     */
    protected $_optionsPageHook;

    /**
     * Constructor.
     *
     * @return void
     */
	public function __construct()
	{

	}

    /**
     * Enqueue scripts/styles.
     *
     * @param string $hook Current page hook
     * @return void
     */
	public function enqueueScripts($hook)
	{
        if ($this->_optionsPageHook != $hook) return;

        wp_register_style('fvch-admin-css', plugins_url('public/css/admin.css', dirname(__FILE__)), false, '1.0');
        wp_enqueue_style('fvch-admin-css');
        wp_enqueue_style('farbtastic');

        wp_enqueue_script('fvch-admin-js', plugins_url('public/js/admin.js', dirname(__FILE__)), array('jquery', 'farbtastic'), '1.0');
	}

    /**
     * Add admin pages to the menu.
     *
     * @return void
     */
	public function adminMenu()
	{
		$this->_optionsPageHook = add_theme_page(
			__('FV Code Highlighter Options', 'fvch'),
			__('Code Highlighter', 'fvch'),
			'edit_themes',
			'fvch-options',
			array($this, 'optionsPage')
		);
	}

    /**
     * Display the admin page.
     *
     * @return void
     */
    public function optionsPage()
    {
        $optionsPage = new FvCodeHighlighter_Admin_Options( FvCodeHighlighter_Container::getInstance()->getOptions() );

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $optionsPage->updateOptions();
        }

        $optionsPage->displayOptions();
    }
}
