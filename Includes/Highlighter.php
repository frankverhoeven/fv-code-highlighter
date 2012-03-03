<?php

/**
 *	Highlighter.php
 *	Highlighter
 *
 *	Code Highlighter
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


abstract class FvCodeHighlighter_Highlighter {
	
	/**
	 *	Code
	 *	@var string
	 */
	protected $_code;
	
	/**
	 *		__construct()
	 *
	 *		@param string $code
	 *		@return void
	 */
	public function __construct($code=null) {
		$this->setCode($code);
	}
	
	/**
	 *		setCode()
	 *
	 *		@param string $code
	 *		@return object $this
	 */
	public function setCode($code) {
		$this->_code = (string) $code;
		return $this;
	}
	
	/**
	 *		getCode()
	 *
	 *		@return string
	 */
	public function getCode() {
		return $this->_code;
	}
	
	/**
	 *		highlight()
	 *
	 *		@return object $this
	 */
	abstract public function highlight();
	
	/**
	 *		getHighlightedCode()
	 *
	 *		@param string $code
	 *		@return string
	 */
	public function getHighlightedCode($code) {
		return $this->setCode($code)->highlight()->getCode();
	}
	
}
