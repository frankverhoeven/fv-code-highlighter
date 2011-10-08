<?php

/**
 *	Key.php
 *	Parser_Key
 *
 *	Code Parser Key
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Parser_Key {
	
	protected $_start;
	protected $_includeStart;
	protected $_end;
	protected $_includeEnd;
	protected $_startPre;
	protected $_startSuf;
	protected $_endPre;
	protected $_endSuf;
	protected $_css;
	protected $_sub;
	protected $_callback;
	
	public function __construct(array $options=array()) {
		$this->setIncludeStart(true);
		$this->setIncludeEnd(true);
		
		if (!empty($options)) {
			$this->setOptions( $options );
		}
	}
	
	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		
		foreach ($options as $name=>$value) {
			$method = 'set' . ucfirst($name);
			
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
	}
	
	
	public function setStart($start) {
		$this->_start = $start;
		return $this;
	}
	public function getStart() {
		return $this->_start;
	}
	
	public function setIncludeStart($includeStart) {
		$this->_includeStart = $includeStart;
		return $this;
	}
	public function getIncludeStart() {
		return $this->_includeStart;
	}
	
	public function setEnd($end) {
		$this->_end = $end;
		return $this;
	}
	public function getEnd() {
		return $this->_end;
	}
	
	public function setIncludeEnd($includeEnd) {
		$this->_includeEnd = $includeEnd;
		return $this;
	}
	public function getIncludeEnd() {
		return $this->_includeEnd;
	}
	
	public function setStartPre($startPre) {
		$this->_startPre = $startPre;
		return $this;
	}
	public function getStartPre() {
		return $this->_startPre;
	}
	
	public function setStartSuf($startStartSuf) {
		$this->_startSuf = $startStartSuf;
		return $this;
	}
	public function getStartSuf() {
		return $this->_startSuf;
	}
	
	public function setEndPre($endPre) {
		$this->_endPre = $endPre;
		return $this;
	}
	public function getEndPre() {
		return $this->_endPre;
	}
	
	public function setEndSuf($endEndSuf) {
		$this->_endSuf = $endEndSuf;
		return $this;
	}
	public function getEndSuf() {
		return $this->_endSuf;
	}
	
	public function setCss($css) {
		$this->_css = $css;
		return $this;
	}
	public function getCss() {
		return $this->_css;
	}
	
	public function setSub($sub) {
		$this->_sub = $sub;
		return $this;
	}
	public function getSub() {
		return $this->_sub;
	}
	
	public function setCallback($callback) {
		$this->_callback = $callback;
		return $this;
	}
	public function getCallback() {
		return $this->_callback;
	}
	
	
	public function hasMultipleStarts() {
		return is_array($this->getStart());
	}
	
	public function hasEnd() {
		if (null == $this->getEnd() || !$this->getEnd()) {
			return false;
		}
		
		return true;
	}
	
	public function hasMultipleEnds() {
		return is_array($this->getEnd());
	}
	
	public function includeEnd() {
		return $this->getIncludeEnd();
	}
	
	public function includeStart() {
		return $this->getIncludeStart();
	}
	
	public function hasSub() {
		if (null == $this->getSub() || !$this->getSub()) {
			return false;
		}
		
		return true;
	}
	
	public function hasCallback() {
		if (null == $this->getCallback() || !$this->getCallback()) {
			return false;
		}
		
		return true;
	}
	
	public function hasStartPre() {
		if (null == $this->getStartPre() || !$this->getStartPre()) {
			return false;
		}
		
		return true;
	}
	
	public function hasStartSuf() {
		if (null == $this->getStartSuf() || !$this->getStartSuf()) {
			return false;
		}
		
		return true;
	}
	
	public function hasEndPre() {
		if (null == $this->getEndPre() || !$this->getEndPre()) {
			return false;
		}
		
		return true;
	}
	
	public function hasEndSuf() {
		if (null == $this->getEndSuf() || !$this->getEndSuf()) {
			return false;
		}
		
		return true;
	}
	
}
