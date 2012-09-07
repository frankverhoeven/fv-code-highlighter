<?php

/**
 * FvCodeHighlighter_Highlighter_Css
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Highlighter_Css extends FvCodeHighlighter_Highlighter
{
	protected $_properties = array(
		'alignment',
		'appearance',
		'azimuth',
		'background',
		'baseline-shift',
		'behavior',
		'binding',
		'bookmark',
		'border',
		'bottom',
		'box',
		'caption-side',
		'clear',
		'clip',
		'color',
		'column',
		'content',
		'counter',
		'crop',
		'cue',
		'cursor',
		'direction',
		'display',
		'dominant-baseline',
		'drop-initial',
		'elevation',
		'empty-cells',
		'fit',
		'fit-position',
		'float',
		'font',
		'grid',
		'hanging-punctuation',
		'height',
		'hyphenate',
		'hyphens',
		'icon',
		'image',
		'inline-box-align',
		'left',
		'letter-spacing',
		'line',
		'list-style',
		'margin',
		'mark',
		'marquee',
		'max-height',
		'max-width',
		'min-height',
		'min-width',
		'move-to',
		'nav',
		'opacity',
		'orphans',
		'outline',
		'overflow',
		'padding',
		'page',
		'pause',
		'phonemes',
		'pitch',
		'pitch-range',
		'play-during',
		'position',
		'presentation-level',
		'punctuation-trim',
		'quotes',
		'rendering-intent',
		'resize',
		'rest',
		'richness',
		'right',
		'rotation',
		'ruby',
		'size',
		'speak',
		'speech-rate',
		'stress',
		'string-set',
		'tab-side',
		'table-layout',
		'target',
		'text',
		'top',
		'unicode-bibi',
		'vertical-align',
		'visibility',
		'voice',
		'volume',
		'white-space',
		'widows',
		'width',
		'word',
		'z-index',
		'-moz-',
		'-webkit-',
		'-o-',
		'-ms-'
	);

	protected $_keys = array(
		array(
			'start'	=> '/*',
			'end'	=> '*/',
			'css'	=> 'css-comment'
		),
	);


	/**
	 *		highlight()
	 *
	 *		@return object $this
	 */
	public function highlight() {
		$string = new FvCodeHighlighter_Parser_Key(array(
			'start'	=> array('"', "'"),
			'end'	=> '@match',
			'css'	=> 'css-string',
			'endPre'=> '[^\\\]'
		));
		$important = new FvCodeHighlighter_Parser_Key(array(
			'start'	=> '!important',
			'css'	=> 'css-important'
		));
		$this->_keys[] = array(
			'start'	=> $this->_properties,
            'startPre'  => '[^a-zA-Z-:]',
			'end'	=> array(';', '}'),
			'includeEnd'	=> false,
			'css'	=> 'css-property',
			'sub'	=> array(new FvCodeHighlighter_Parser_Key(array(
				'start'	=> ':',
				'end'	=> array(';', '}'),
				'css'	=> 'css-value',
				'includeStart'	=> false,
				'includeEnd'	=> false,
				'sub'	=> array($string, $important)
			)))
		);
		$this->_keys[] = array(
			'start'	=> '@import',
			'end'	=> array(';', "\n"),
			'css'	=> 'css-import',
			'sub'	=> array($string)
		);
		$this->_keys[] = array(
			'start'	=> '@media',
			'end'	=> '{',
			'css'	=> 'css-media'
		);


		foreach ($this->_keys as $i=>$key) {
			if (!($key instanceof FvCodeHighlighter_Parser_Key)) {
				$this->_keys[ $i ] = new FvCodeHighlighter_Parser_Key($key);
			}
		}

		$parser = new FvCodeHighlighter_Parser( $this->getCode() );

		$parser->setKeys($this->_keys)
			   ->parse();

		// Fixes
		$code = str_replace(':<span class="css-value">', '<span class="css-selector">:</span><span class="css-value">', $parser->getParsedCode());
		$code = preg_replace('/\}(\s*?)\}/', '}\\1<span class="css-media">}</span>', $code);

		$this->setCode( '<span class="css">' . $code . '</span>' );

		return $this;
	}

}
