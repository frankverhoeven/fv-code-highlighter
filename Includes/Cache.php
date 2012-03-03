<?php

/**
 *	Cache.php
 *	Cache
 *
 *	Cacher
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Cache {
	
	/**
	 *	Cache dir
	 *	@var string
	 */
	protected $_cacheDir;
	
	/**
	 *		__construct()
	 *
	 *		@return void
	 */
	public function __construct($cacheDir) {
		$this->setCacheDir( realpath($cacheDir) . '/' );
	}
	
	/**
	 *		setCacheDir()
	 *
	 *		@param string $dir
	 *		@return object $this
	 */
	public function setCacheDir($dir) {
		$this->_cacheDir = $dir;
		return $this;
	}
	
	/**
	 *		getCacheDir()
	 *
	 *		@return string
	 */
	public function getCacheDir() {
		return $this->_cacheDir;
	}
	
	/**
	 *		cacheFileExists()
	 *
	 *		@param string $name
	 *		@return bool
	 */
	public function cacheFileExists($name) {
		return file_exists($this->getCacheDir() . $name);
	}
	
	/**
	 *		createCacheFile()
	 *
	 *		@param string $name
	 *		@param string $content
	 *		@return object $this
	 */
	public function createCacheFile($name, $content) {
		if ($handle = fopen($this->getCacheDir() . $name, 'w+')) {
			fwrite($handle, $content);
			fclose($handle);
		}
		
		return $this;
	}
	
	/**
	 *		getCacheFile()
	 *
	 *		@param string $name
	 *		@return string
	 */
	public function getCacheFile($name) {
		if (!$this->cacheFileExists($name)) {
			throw new Exception('The requested cache file does not exist');
		}
		
		return file_get_contents($this->getCacheDir() . $name);
	}
	
	/**
	 *		clear()
	 *
	 *		@return object $this
	 */
	public function clear() {
		if ($dr = opendir($this->getCacheDir())) {
			while (false !== ($file = readdir($dr))) {
				if ('.' != $file && '..' != $file) {
					unlink($this->getCacheDir() . $file);
				}
			}
			
			closedir($dr);
		}
		
		return $this;
	}
	
}
