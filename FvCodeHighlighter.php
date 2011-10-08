<?php

/**
 *	Plugin Name:	FV Code Highlighter
 *	Plugin URI:		http://www.frank-verhoeven.com/wordpress-plugin-fv-code-highlighter/
 *	Description:	Highlight your code, Dreamweaver style.
 *	Author:			Frank Verhoeven
 *	Author URI:		http://www.frank-verhoeven.com/
 *	Version:		1.7
 */

/**
 *		FvCodeHighlighter.php
 *		FvCodeHighlighter
 *
 *		Highlight your code, Dreamweaver style.
 *
 *		@author		Frank Verhoeven
 *		@version	1.7
 */


if (!class_exists('FvCodeHighlighter')) {
	
	final class FvCodeHighlighter {
		
		/**
		 *		__construct()
		 *
		 */
		public function __construct() {
			$this->_setupVars()
				 ->_loadFiles()
				 ->_setupActions()
				 
				 ->init();
		}
		
		/**
		 *		_setupVars()
		 *
		 *		@return object $this
		 */
		protected function _setupVars() {
			define('FVCH_ROOT', dirname(__FILE__));
			
			return $this;
		}
		
		/**
		 *		_loadFiles()
		 *
		 *		@return object $this
		 */
		protected function _loadFiles() {
			require_once FVCH_ROOT . '/Includes/Loader.php';
			$loader = new FvCodeHighlighter_Loader(FVCH_ROOT);
			
			spl_autoload_register(array($loader, 'autoload'));
			
			$loader->loadFile('/Includes/Functions.php');
			$loader->loadFile('/Includes/Hooks.php');
			
			return $this;
		}
		
		/**
		 *		_setupActions()
		 *
		 *		@return object $this
		 */
		protected function _setupActions() {
			register_activation_hook(__FILE__, 'fvch_activation');
			register_deactivation_hook(__FILE__, 'fvch_deactivation');
			if (!FvCodeHighlighter_Version::compareCurrent(FvCodeHighlighter_Version::getInstalled())) {
				fvch_install();
			}
			
			return $this;
		}
		
		/**
		 *		init()
		 *
		 *		@return void
		 */
		public function init() {
			
			
			
		}
		
	}
	
	$FvCodeHighlighter = new FvCodeHighlighter();
}


/**
 *		fvch_activation()
 *
 *		@return void
 */
function fvch_activation() {
	register_uninstall_hook(__FILE__, 'fvch_uninstall');
	
	do_action('fvch_activation');
}

/**
 *		fvch_deactivation()
 *
 */
function fvch_deactivation() {
	
	do_action('fvch_deactivation');
	
}

/**
 *		fvch_uninstall()
 *
 */
function fvch_uninstall() {
	
	do_action('fvch_uninstall');
	
}


/**
 *
 *		Q.E.D.
 *
 */
