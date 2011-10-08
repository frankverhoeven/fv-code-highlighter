<?php

/**
 *	Install.php
 *	FvCodeHighlighter/Install
 *
 *	Handles plugin installation
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Install {
	
	/**
	 *	Current Version
	 *	@var string
	 */
	protected $_version;
	
	/**
	 *		__construct()
	 *
	 *		@return void
	 */
	public function __construct($version) {
		$this->_version = $version;
		
	}
	
	/**
	 *		getVersion()
	 *
	 *		@return string
	 */
	public function getVersion() {
		return $this->_version;
	}
	
	/**
	 *		installSettings()
	 *
	 *		@return object $this
	 */
	public function installSettings() {
		foreach (FvCodeHighlighter_Config_Default::getConfig() as $key=>$value) {
			switch ($key) {
				case 'fvch_version' :
					update_option($key, $this->getVersion());
					break;
				default :
					add_option($key, $value);
				
			}
		}
		
		return $this;
	}
	
	/**
	 *		deleteDeprecated()
	 *
	 *		@return object $this
	 */
	public function deleteDeprecated() {
		foreach (FvCodeHighlighter_Config_Deprecated::getConfig() as $key) {
			delete_option( $key );
		}
		
		return $this;
	}
	
}
