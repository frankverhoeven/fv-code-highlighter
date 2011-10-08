<?php

/**
 *	Default.php
 *	Config_Default
 *
 *	Default Settings
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Config_Default extends FvCodeHighlighter_Config {
	
	/**
	 *		getConfig()
	 *
	 *		@return array
	 */
	public static function getConfig() {
		return array(
			'fvch_version'			=> '',
			'fvch-cache-dir'		=> FVCH_ROOT . '/cache',
			'fvch-font-family'		=> 'Monaco',
			'fvch-font-size'		=> '11',
			'fvch-background'		=> 'notepaper',
			'fvch-line-numbers'		=> '1'
		);
	}
	
}
