<?php

/**
 *	Xml.php
 *	Highlighter_Xml
 *
 *	XML Highlighter
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class Highlighter_Xml extends FvCodeHighlighter_Highlighter {
	
	protected $_keys = array();
	
	/**
	 *		highlight()
	 *
	 *		@return object $this
	 */
	public function highlight() {
		$string = new Parser_Key(array(
			'start'	=> array('"', "'"),
			'end'	=> '@match',
			'css'	=> 'xml-string'
		));
		
		$this->_keys[] = array(
			'start'	=> '<!--',
			'end'	=> '-->',
			'css'	=> 'xml-comment'
		);
		$this->_keys[] = array(
			'start'	=> '<',
			'end'	=> '>',
			'css'	=> 'xml-element',
			'sub'	=> array($string)
		);
		$this->_keys[] = array(
			'start'	=> array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
			'css'	=> 'xml-number'
		);
		
		
		foreach ($this->_keys as $i=>$key) {
			if (!($key instanceof FvCodeHighlighter_Parser_Key)) {
				$this->_keys[ $i ] = new FvCodeHighlighter_Parser_Key($key);
			}
		}
		
		$parser = new FvCodeHighlighter_Parser( $this->getCode() );
		
		$parser->setKeys($this->_keys)
			   ->parse();
		
		$this->setCode( '<span class="xml">' . $parser->getParsedCode() . '</span>' );
		
		return $this;
	}
	
}

?>