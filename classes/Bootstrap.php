<?php

/**
 * FvCodeHighlighter_Bootstrap
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Bootstrap extends FvCodeHighlighter_Bootstrap_Abstract
{
	/**
	 * Run the installer if necessary.
	 */
	protected function _initInstaller()
	{
		$installer = new FvCodeHighlighter_Installer();

		if ($installer->isInstall()) {
			$installer->doInstall();
		} else if ($installer->isUpdate()) {
			$installer->doUpdate();
		}
        FvCodeHighlighter_Container::getInstance()->getCache()->clear();
	}

    /**
     * Plugin output
     */
    protected function _initOutput()
    {
        $output = new FvCodeHighlighter_Output( FvCodeHighlighter_Container::getInstance()->getOptions() );

        // WordPress
        add_filter('the_content',           array($output, 'highlightCode'), 3);
        add_filter('comment_text',          array($output, 'highlightCode'), 3);
        // bbPress
        add_filter('bbp_get_topic_content', array($output, 'highlightCode'), 3);
        add_filter('bbp_get_reply_content', array($output, 'highlightCode'), 3);

        add_action('wp_enqueue_scripts',    array($output, 'enqueueScripts'));

        add_action('wp_head',               array($output, 'displayHead'));
    }

	/**
	 * Admin area
	 */
	protected function _initAdmin()
	{
		if (!is_admin()) return;

		$admin = new FvCodeHighlighter_Admin();

		add_action('admin_enqueue_scripts',	array($admin, 'enqueueScripts'	));
		add_action('admin_menu',			array($admin, 'adminMenu'       ));
	}
}

