<?php

/**
 *	Loader.php
 *	FvCodeHighlighter/Loader
 *
 *	Loader
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Loader {
	
	/**
	 *	Plugin root dir
	 *	@var string
	 */
	protected $_root;
	
	/**
	 *		__construct()
	 *
	 *		@param string $root
	 *		@return void
	 */
	public function __construct($root) {
		if (!is_dir($root)) {
			throw new Exception('Root directory does not exist.');
		}
		
		$this->setRoot($root);
	}
	
	/**
	 *		setRoot()
	 *
	 *		@param string $root
	 *		@return object $this
	 */
	public function setRoot($root) {
		$this->_root = $root;
		return $this;
	}
	
	/**
	 *		getRoot()
	 *
	 *		@return string
	 */
	public function getRoot() {
		return $this->_root;
	}
	
	/**
	 *		loadFile()
	 *
	 *		@param string $file
	 *		@return void
	 */
	public function loadFile($file) {
		if (file_exists($file)) {
			include $file;
		} else if (file_exists($this->getRoot() . $file)) {
			include $this->getRoot() . $file;
		} else {
			return false;
		}
		
		return true;
	}
	
	/**
	 *		autoload()
	 *
	 *		@param string $class
	 *		@return void
	 */
	public function autoload($class) {
		if (!strstr($class, 'FvCodeHighlighter_'))
			return;
		
		$file = str_replace('_', '/', str_replace('FvCodeHighlighter_', '', $class)) . '.php';
		
		if (!$this->loadFile('/Includes/' . $file)) {
			//echo 'Can\'t load class \'' . $class . '\' (' . $file . ')' . "\n";
		}
	}
	
}
