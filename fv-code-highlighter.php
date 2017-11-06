<?php

/**
 * Plugin Name: FV Code Highlighter
 * Description: Highlight your code, Dreamweaver style.
 * Plugin URI:  https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/
 * Author:      Frank Verhoeven
 * Author URI:  https://frankverhoeven.me/
 * Version:     1.8
 */

if (!defined('ABSPATH')) exit;


/**
 * FvCodeHighlighter
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
if (!class_exists('FvCodeHighlighter'))
{
	final class FvCodeHighlighter
	{
		/**
		 * Constructor.
		 *
		 * @return void
		 */
		public function __construct()
		{
			$this->_setupAutoloader();
		}

		/**
		 * Setup the autoloader.
		 *
		 * @return \FvCodeHighlighter
		 */
		protected function _setupAutoloader()
		{
			$root = dirname(__FILE__) . '/classes';

			require_once $root . '/Loader/Interface.php';
			require_once $root . '/Loader.php';

			$loader = new FvCodeHighlighter_Loader();
			$loader->loadFile($root . '/Loader/Autoloader.php');

			$autoloader = new FvCodeHighlighter_Loader_Autoloader($root, $loader);
			$autoloader->register();

			return $this;
		}

		/**
		 * Bootstrap the application.
		 *
		 * @return \FvCodeHighlighter
		 */
		public function start()
		{
			$bootstrap = new FvCodeHighlighter_Bootstrap();
			$bootstrap->bootstrap();

			return $this;
		}
	}

	// Start the application
	try {
		$FvCodeHighlighter = new FvCodeHighlighter();
		$FvCodeHighlighter->start();
	} catch (Exception $e) {
		if (defined('WP_DEBUG') && true === WP_DEBUG) {
			printf('<h3>%s</h3><pre>%s</pre>', $e->getMessage(), $e->getTraceAsString());
		}

		error_log( $e->getMessage() . PHP_EOL . $e->getTraceAsString() );
	}
}


/**
 *
 *		Q.E.D.
 *
 */

