<?php

/**
 *	Block.php
 *	Parser_Block
 *
 *	Code Block Parser
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */

namespace FvCodeHighlighter;


class Parser_Block extends Parser {
	
	/**
	 *	Block starter
	 *	@var string
	 */
	protected $_start;
	
	/**
	 *	Block end
	 *	@var string
	 */
	protected $_end;
	
	/**
	 *	CSS class
	 *	@var string
	 */
	protected $_cssClass;
	
	/**
	 *		init()
	 *
	 *		@param array $options
	 *		@return object $this
	 */
	public function init(array $options=array()) {
		if (!empty($options)) {
			$this->setOptions( $options );
		}
		
		return $this;
	}
	
	/**
	 *		setOptions()
	 *
	 *		@param array $options
	 *		@return object $this
	 */
	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		
		foreach ($options as $key=>$value) {
			$func = 'set' . $key;
			
			if (in_array($func, $methods)) {
				$this->$func( $value );
			}
		}
		
		return $this;
	}
	
	/**
	 *		setStart()
	 *
	 *		@param string $start
	 *		@return object $this
	 */
	public function setStart($start) {
		$this->_start = (string) $start;
		return $this;
	}
	
	/**
	 *		getStart()
	 *
	 *		@return string
	 */
	public function getStart() {
		return $this->_start;
	}
	
	/**
	 *		setEnd()
	 *
	 *		@param string $end
	 *		@return object $this
	 */
	public function setEnd($end) {
		$this->_end = (string) $end;
		return $this;
	}
	
	/**
	 *		getEnd()
	 *
	 *		@return string
	 */
	public function getEnd() {
		return $this->_end;
	}
	
	/**
	 *		setCssClass()
	 *
	 *		@param string $class
	 *		@return object $this
	 */
	public function setCssClass($class) {
		$this->_cssClass = (string) $class;
		return $this;
	}
	
	/**
	 *		getCssClass()
	 *
	 *		@return string
	 */
	public function getCssClass() {
		return $this->_cssClass;
	}
	
	
	
	
}
