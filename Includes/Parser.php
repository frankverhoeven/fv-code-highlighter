<?php

/**
 *	Parser.php
 *	Parser
 *
 *	Code Parser
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Parser {
	
	/**
	 *	Code
	 *	@var string
	 */
	protected $_code = null;
	
	/**
	 *	Parsed Code
	 *	@var string
	 */
	protected $_parsedCode = '';
	
	/**
	 *	Pointer
	 *	@var int
	 */
	protected $_pointer = 0;
	
	/**
	 *	Keys
	 *	@var array
	 */
	protected $_keys = array();
	
	/**
	 *	Current open key
	 *	@var int
	 */
	protected $_currentKey = 0;
	
	/**
	 *	Curernt start
	 *	@var string
	 */
	protected $_currentStart = '';
	
	/**
	 *	Current end
	 *	@var string
	 */
	protected $_currentEnd = '';
	
	/**
	 *		__construct()
	 *
	 *		@param string $code
	 */
	public function __construct($code) {
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
	 *		setParsedCode()
	 *
	 *		@param string $code
	 *		@return object $this
	 */
	public function setParsedCode($code) {
		$this->_parsedCode = (string) $code;
		return $this;
	}
	
	/**
	 *		getParsedCode()
	 *
	 *		@return string
	 */
	public function getParsedCode() {
		return $this->_parsedCode;
	}
	
	/**
	 *		addParsedCode()
	 *
	 *		@param string $code
	 *		@return object $this
	 */
	public function addParsedCode($code) {
		$this->setParsedCode( $this->getParsedCode() . $code );
		return $this;
	}
	
	/**
	 *		setPointer()
	 *
	 *		@param int $pointer
	 *		@return object $this
	 */
	public function setPointer($pointer) {
		$this->_pointer = (int) $pointer;
		return $this;
	}
	
	/**
	 *		getPointer()
	 *
	 *		@return int
	 */
	public function getPointer() {
		return $this->_pointer;
	}
	
	/**
	 *		increasePointer()
	 *
	 *		@param int (optional) $increment
	 *		@return object $this
	 */
	public function increasePointer($increment=1) {
		$this->setPointer( $this->getPointer() + $increment );
		return $this;
	}
	
	/**
	 *		setKeys()
	 *
	 *		@param array $keys
	 *		@return object $this
	 */
	public function setKeys($keys) {
		$this->_keys = $keys;
		return $this;
	}
	
	/**
	 *		getKeys()
	 *
	 *		@return array
	 */
	public function getKeys() {
		return $this->_keys;
	}
	
	/**
	 *		getKey()
	 *
	 *		@param int $key
	 *		@return array
	 */
	public function getKey($key) {
		return $this->_keys[ $key ];
	}
	
	/**
	 *		addKey()
	 *
	 *		@param array $key
	 *		@return object $this
	 */
	public function addKey($key) {
		$this->_keys[] = $key;
		return $this;
	}
	
	/**
	 *		setCurrentKey()
	 *
	 *		@param object $key
	 *		@return object $this
	 */
	public function setCurrentKey($key) {
		$this->_currentKey = $this->_keys[ $key ];
		return $this;
	}
	
	/**
	 *		getCurrentKey()
	 *
	 *		@return int
	 */
	public function getCurrentKey() {
		return $this->_currentKey;
	}
	
	/**
	 *		setCurrentStart()
	 *
	 *		@param string $start
	 *		@return object $this
	 */
	public function setCurrentStart($start) {
		$this->_currentStart = (string) $start;
		return $this;
	}
	
	/**
	 *		getCurrentStart()
	 *
	 *		@return string
	 */
	public function getCurrentStart() {
		return $this->_currentStart;
	}
	
	/**
	 *		setCurrentEnd()
	 *
	 *		@param string $end
	 *		@return object $this
	 */
	public function setCurrentEnd($end) {
		$this->_currentEnd = (string) $end;
		return $this;
	}
	
	/**
	 *		getCurrentEnd()
	 *
	 *		@return string
	 */
	public function getCurrentEnd() {
		return $this->_currentEnd;
	}
	
	/**
	 *		parse()
	 *
	 *		@return object $this
	 */
	public function parse() {
		$this->setPointer(0);
		$code = $this->getCode();
		
		while ($this->getPointer() < strlen($code)) {
			$subCode = substr($code, $this->getPointer());
			
			if ($this->_findStart($subCode)) {
				if ($this->getCurrentKey()->includeStart()) {
					$parsed = '<span class="' . $this->getCurrentKey()->getCss() . '">';
					$parsed .= htmlspecialchars($this->getCurrentStart());
				} else {
					$parsed = htmlspecialchars($this->getCurrentStart());
					$parsed .= '<span class="' . $this->getCurrentKey()->getCss() . '">';
				}
				
				$this->increasePointer( strlen($this->getCurrentStart()) );
				
				if ($this->getCurrentKey()->hasEnd()) {
					$subCode = substr($code, $this->getPointer());
					$pointer = $this->getPointer();
					
					$end = true;
					while (!$this->_findEnd($subCode)) {
						$this->increasePointer();
						$subCode = substr($code, $this->getPointer());
						
						if ($this->getPointer() > strlen($code)) {
							$end = false;
							break;
						}
					}
					
					$subsubCode = substr($code, $pointer, $this->getPointer() - $pointer);
					if ($this->getCurrentKey()->hasSub() || $this->getCurrentKey()->hasCallback()) {
						if ($this->getCurrentKey()->hasSub()) {
							if (!$this->getCurrentKey()->includeEnd()) {
								$parser = new FvCodeHighlighter_Parser($subsubCode . $this->getCurrentEnd());
								$subsubCode = substr($parser->setKeys( $this->getCurrentKey()->getSub() )
													 ->parse()
													 ->getParsedCode(), 0, -1);
							} else {
								$parser = new FvCodeHighlighter_Parser($subsubCode);
								$subsubCode = $parser->setKeys( $this->getCurrentKey()->getSub() )
													 ->parse()
													 ->getParsedCode();
							}
						}
						if ($this->getCurrentKey()->hasCallback()) {
							$subsubCode = call_user_func($this->getCurrentKey()->getCallback(), $subsubCode);
						}
						
						$parsed .= $subsubCode;
					} else {
						$parsed .= htmlspecialchars($subsubCode);
					}
					
					if ($this->getCurrentKey()->includeEnd()) {
						if ($end) {
							$parsed .= htmlspecialchars($this->getCurrentEnd());
						}
						$this->increasePointer( strlen($this->getCurrentEnd()) );
					}
				}
				
				$parsed .= '</span>';
				$this->addParsedCode( $parsed );
			} else {
				$this->addParsedCode( htmlspecialchars($code[ $this->getPointer() ]) );
				$this->increasePointer();
			}
		}
		
		return $this;
	}
	
	
	/**
	 *		_findStart()
	 *
	 *		@param string $code
	 *		@return bool
	 */
	public function _findStart($code) {
		foreach ($this->getKeys() as $id=>$key) {
			$match = false;
			
			if (($key->hasStartPre() && $this->_checkStartPrefix($key)) || !$key->hasStartPre()) {
				if ($key->hasMultipleStarts()) {
					foreach ($key->getStart() as $start) {
						if ($start == substr($code, 0, strlen($start))) {
							if (($key->hasStartSuf() && $this->_checkStartSuffix($start, $key)) || !$key->hasStartSuf()) {
								$match = true;
								$this->setCurrentStart( $start );
							}
						}
					}
				} else {
					if ($key->getStart() == substr($code, 0, strlen($key->getStart()))) {
						if (($key->hasStartSuf() && $this->_checkStartSuffix($key->getStart(), $key)) || !$key->hasStartSuf()) {
							$match = true;
							$this->setCurrentStart( $key->getStart() );
						}
					}
				}
			}
			
			if ($match) {
				$this->setCurrentKey( $id );
				
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 *		_findEnd()
	 *
	 *		@param string $code
	 *		@return bool
	 */
	protected function _findEnd($code) {
		$match = false;
		
		if (($this->getCurrentKey()->hasEndPre() && $this->_checkEndPrefix()) || !$this->getCurrentKey()->hasEndPre()) {
			if ($this->getCurrentKey()->hasMultipleEnds()) {
				foreach ($this->getCurrentKey()->getEnd() as $end) {
					if ($end == substr($code, 0, strlen($end))) {
						if (($this->getCurrentKey()->hasEndSuf() && $this->_checkEndSuffix($end)) || !$this->getCurrentKey()->hasEndSuf()) {
							$match = true;
							$this->setCurrentEnd( $end );
						}
					}
				}
			} else {
				if ('@match' == $this->getCurrentKey()->getEnd()) {
					$end = $this->getCurrentStart();
				} else {
					$end = $this->getCurrentKey()->getEnd();
				}
				
				if ($end == substr($code, 0, strlen($end))) {
					if (($this->getCurrentKey()->hasEndSuf() && $this->_checkEndSuffix($end)) || !$this->getCurrentKey()->hasEndSuf()) {
						$match = true;
						$this->setCurrentEnd( $end );
					}
				}
			}
		}
		
		return $match;
	}
	
	/**
	 *		_checkStartPrefix()
	 *
	 *		@return bool
	 */
	protected function _checkStartPrefix($key) {
		$prefix = substr($this->getCode(), $this->getPointer()-1, 1);
		
		if (preg_match('/' . $key->getStartPre() . '/', $prefix)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 *		_checkStartSuffix()
	 *
	 *		@return bool
	 */
	protected function _checkStartSuffix($start, $key) {
		$suffix = substr($this->getCode(), $this->getPointer()+strlen($start), 1);
		
		if (preg_match('/' . $key->getStartSuf() . '/', $suffix)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 *		_checkEndPrefix()
	 *
	 *		@return bool
	 */
	protected function _checkEndPrefix() {
		$prefix = substr($this->getCode(), $this->getPointer()-1, 1);
		
		if (preg_match('/' . $this->getCurrentKey()->getEndPre() . '/', $prefix)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 *		_checkEndSuffix()
	 *
	 *		@return bool
	 */
	protected function _checkEndSuffix($end) {
		$suffix = substr($this->getCode(), $this->getPointer()+strlen($end), 1);
		
		if (preg_match('/' . $this->getCurrentKey()->getEndSuf() . '/', $suffix)) {
			return true;
		}
		
		return false;
	}
	
}
