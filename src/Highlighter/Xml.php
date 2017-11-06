<?php

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Key;
use FvCodeHighlighter\Parser\Parser;

/**
 * Xml
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Xml extends AbstractHighlighter
{
	protected $keys = [];
	
	/**
	 * highlight()
	 *
	 * @return $this
	 */
	public function highlight()
    {
		$string = new Key([
			'start'	=> ['"', "'"],
			'end'	=> '@match',
			'css'	=> 'xml-string'
        ]);
		
		$this->keys[] = [
			'start'	=> '<!--',
			'end'	=> '-->',
			'css'	=> 'xml-comment'
        ];
		$this->keys[] = [
			'start'	=> '<',
			'end'	=> '>',
			'css'	=> 'xml-element',
			'sub'	=> [$string]
        ];
		$this->keys[] = [
			'start'	=> ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
			'css'	=> 'xml-number'
        ];
		
		foreach ($this->keys as $i=>$key) {
			if (!($key instanceof Key)) {
				$this->keys[ $i ] = new Key($key);
			}
		}
		
		$parser = new Parser($this->getCode());
		
		$parser->setKeys($this->keys)
			   ->parse();
		
		$this->setCode('<span class="xml">' . $parser->getParsedCode() . '</span>');
		
		return $this;
	}
}
