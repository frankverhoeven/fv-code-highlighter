<?php

/**
 *	Html.php
 *	Highlighter_Html
 *
 *	(x)HTML Highlighter
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Highlighter_Html extends FvCodeHighlighter_Highlighter {
	
	protected $_keys = array(
		array(
			'start'	=> '<!--',
			'end'	=> '-->',
			'css'	=> 'html-comment'
		),
		
	);
	
	/**
	 *		highlight()
	 *
	 *		@return object $this
	 */
	public function highlight() {
		$attribute = new FvCodeHighlighter_Parser_Key(array(
			'start'	=> array('"', "'"),
			'end'	=> '@match',
			'css'	=> 'html-attribute'
		));
		$this->_keys[] = array(
			'start'	=> array('<form', '</form', '<input', '<select', '</select', '<option', '</option', '<textarea', '</textarea', '<button', '</button'),
			'end'	=> '>',
			'css'	=> 'html-form-element',
			'sub'	=> array($attribute)
		);
		$this->_keys[] = array(
			'start'	=> array('<a', '</a'),
			'end'	=> '>',
			'css'	=> 'html-anchor-element',
			'sub'	=> array($attribute)
		);
		$this->_keys[] = array(
			'start'	=> '<img',
			'end'	=> '>',
			'css'	=> 'html-image-element',
			'sub'	=> array($attribute)
		);
		$this->_keys[] = array(
			'start'	=> array('<script', '</script'),
			'end'	=> '>',
			'css'	=> 'html-script-element',
			'sub'	=> array($attribute)
		);
		$this->_keys[] = array(
			'start'	=> array('<style', '</style'),
			'end'	=> '>',
			'css'	=> 'html-style-element',
			'sub'	=> array(new FvCodeHighlighter_Parser_Key(array(
				'start'	=> array('"', "'"),
				'end'	=> '@match',
				'css'	=> 'css-string'
			)))
		);
		$this->_keys[] = array(
			'start'	=> array('<table', '</table', '<tbody', '</tbody', '<thead', '</thead', '<tfoot', '</tfoot', '<th', '</th', '<tr', '</tr', '<td', '</td'),
			'end'	=> '>',
			'css'	=> 'html-table-element',
			'sub'	=> array($attribute)
		);
		$this->_keys[] = array(
			'start'	=> '<',
			'end'	=> '>',
			'css'	=> 'html-other-element',
			'sub'	=> array($attribute)
		);
		$this->_keys[] = array(
			'start'	=> '&',
			'end'	=> array(';', "\n", ' ', "\t"),
			'css'	=> 'html-special-char'
		);
		
		
		foreach ($this->_keys as $i=>$key) {
			if (!($key instanceof FvCodeHighlighter_Parser_Key)) {
				$this->_keys[ $i ] = new FvCodeHighlighter_Parser_Key($key);
			}
		}
		
		$parser = new FvCodeHighlighter_Parser( $this->getCode() );
		
		$parser->setKeys($this->_keys)
			   ->parse();
		
		$code = $parser->getParsedCode();
		
		preg_match_all('/&lt;style(.*?)&gt;(?<code>.*?)&lt;\/style&gt;/msi', $code, $cssCode);
		for ($i=0; $i<count($cssCode[0]); $i++) {
			$highlighter = new FvCodeHighlighter_Highlighter_Css( htmlspecialchars_decode( strip_tags($cssCode['code'][$i]) ) );
			$highlighter->highlight();
			
			$code = str_replace($cssCode['code'][$i], '<span class="css">' . $highlighter->getCode() . '</span>', $code);
		}
		preg_match_all('/style=<span class="html-attribute">&quot;(?<code>.*?)&quot;<\/span>/msi', $code, $cssCode);
		for ($i=0; $i<count($cssCode[0]); $i++) {
			$highlighter = new FvCodeHighlighter_Highlighter_Css( htmlspecialchars_decode( strip_tags($cssCode['code'][$i]) ) );
			$highlighter->highlight();
			$code = str_replace($cssCode['code'][$i], '<span class="css">' . $highlighter->getCode() . '</span>', $code);
		}
		
		preg_match_all('/&lt;script(.*?)&gt;(?<code>.*?)&lt;\/script&gt;/msi', $code, $jsCode);
		for ($i=0; $i<count($jsCode[0]); $i++) {
			$highlighter = new FvCodeHighlighter_Highlighter_Javascript( htmlspecialchars_decode( strip_tags($jsCode['code'][$i]) ) );
			$highlighter->highlight();
			
			$code = str_replace($jsCode['code'][$i], '<span class="js">' . $highlighter->getCode() . '</span>', $code);
		}
		
		
		$this->setCode( '<span class="html">' . $code . '</span>' );
		
		return $this;
	}
	
}
