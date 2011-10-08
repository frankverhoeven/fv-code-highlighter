<?php

/**
 *	Version.php
 *	FvCodeHighlighter/Version
 *
 *	Plugin Version
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


final class FvCodeHighlighter_Version {
	
	/**
	 *	FV Code Highlighter Version
	 */
	const VERSION = '1.7';
	
	/**
	 *	Installed Version
	 *	@var string
	 */
	protected static $_installedVersion;
	
	/**
	 *	Latest Version
	 *	@var string
	 */
	protected static $_latestVersion;
	
	/**
	 *		getInstalled()
	 *
	 *		@uses get_option()
	 *		@return string
	 */
	public static function getInstalled() {
		if (null == self::$_installedVersion) {
			self::$_installedVersion = get_option('fvch_version');
		}
		
		return self::$_installedVersion;
	}
	
	/**
	 *		getLatest()
	 *
	 *		@return string
	 */
	public static function getLatest() {
		if (null == self::$_latestVersion) {
			self::$_latestVersion = 'not available';
			
			$handle = fopen('http://www.frank-verhoeven.com/fv-code-highlighter/version.php', 'r');
			if (false !== $handle) {
				self::$_latestVersion = stream_get_contents($handle);
				fclose($handle);
			}
		}
		
		return self::$_latestVersion;
	}
	
	/**
	 *		compareInstalledVersion()
	 *
	 *		@param string $version
	 *		@return int
	 */
	public static function compareInstalled($version) {
		return version_compare($version, self::getInstalled(), '>=');
	}
	
	/**
	 *		compareCurrentVersion()
	 *
	 *		@param string $version
	 *		@return int
	 */
	public static function compareCurrent($version) {
		return version_compare($version, self::VERSION, '>=');
	}
	
}
