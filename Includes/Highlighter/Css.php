<?php

/**
 *	Css.php
 *	Highlighter_Css
 *
 *	CSS Highlighter
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Highlighter_Css extends FvCodeHighlighter_Highlighter {
	
	protected $_properties = array(
		'alignment-adjust',
		'alignment-baseline',
		'appearance',
		'azimuth',
		'background',
		'background-attachment',
		'background-break',
		'background-clip',
		'background-color',
		'background-image',
		'background-origin',
		'background-position',
		'background-repeat',
		'background-size',
		'baseline-shift',
		'behavior',
		'binding',
		'bookmark-label',
		'bookmark-level',
		'bookmark-target',
		'border',
		'border-bottom',
		'border-bottom-color',
		'border-bottom-left-radius',
		'border-bottom-right-radius',
		'border-bottom-style',
		'border-bottom-width',
		'border-break',
		'border-collapse',
		'border-color',
		'border-image',
		'border-left',
		'border-left-color',
		'border-left-style',
		'border-left-width',
		'border-length',
		'border-radius',
		'border-right',
		'border-right-color',
		'border-right-style',
		'border-right-width',
		'border-spacing',
		'border-style',
		'border-top',
		'border-top-color',
		'border-top-left-radius',
		'border-top-right-radius',
		'border-top-style',
		'border-top-width',
		'border-width',
		'bottom',
		'box-align',
		'box-direction',
		'box-flex',
		'box-flex-group',
		'box-lines',
		'box-orient',
		'box-pack',
		'box-shadow',
		'box-sizing',
		'caption-side',
		'clear',
		'clip',
		'color',
		'color-profile',
		'column-break-after',
		'column-break-before',
		'column-count',
		'column-fill',
		'column-gap',
		'column-rule',
		'column-rule-color',
		'column-rule-style',
		'column-rule-width',
		'column-span',
		'column-width',
		'columns',
		'content',
		'counter-increment',
		'counter-reset',
		'crop',
		'cue',
		'cue-after',
		'cue-before',
		'cursor',
		'direction',
		'display',
		'dominant-baseline',
		'drop-initial-after-adjust',
		'drop-initial-after-align',
		'drop-initial-before-adjust',
		'drop-initial-before-align',
		'drop-initial-size',
		'drop-initial-value',
		'elevation',
		'empty-cells',
		'fit',
		'fit-position',
		'float',
		'float-offset',
		'font',
		'font-effect',
		'font-emphasize',
		'font-emphasize-position',
		'font-emphasize-style',
		'font-family',
		'font-size',
		'font-size-adjust',
		'font-smooth',
		'font-stretch',
		'font-style',
		'font-variant',
		'font-weight',
		'grid-columns',
		'grid-rows',
		'hanging-punctuation',
		'height',
		'hyphenate-after',
		'hyphenate-before',
		'hyphenate-character',
		'hyphenate-lines',
		'hyphenate-resource',
		'hyphens',
		'icon',
		'image-orientation',
		'image-resolution',
		'inline-box-align',
		'left',
		'letter-spacing',
		'line-height',
		'line-stacking',
		'line-stacking-ruby',
		'line-stacking-shift',
		'line-stacking-strategy',
		'list-style',
		'list-style-image',
		'list-style-position',
		'list-style-type',
		'margin',
		'margin-bottom',
		'margin-left',
		'margin-right',
		'margin-top',
		'mark',
		'mark-after',
		'mark-before',
		'marker-offset',
		'marks',
		'marquee-direction',
		'marquee-play-count',
		'marquee-speed',
		'marquee-style',
		'max-height',
		'max-width',
		'min-height',
		'min-width',
		'move-to',
		'nav-down',
		'nav-index',
		'nav-left',
		'nav-right',
		'nav-up',
		'opacity',
		'orphans',
		'outline',
		'outline-color',
		'outline-offset',
		'outline-style',
		'outline-width',
		'overflow',
		'overflow-style',
		'overflow-x',
		'overflow-y',
		'padding',
		'padding-bottom',
		'padding-left',
		'padding-right',
		'padding-top',
		'page',
		'page-break-after',
		'page-break-before',
		'page-break-inside',
		'page-policy',
		'pause',
		'pause-after',
		'pause-before',
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
		'rest-after',
		'rest-before',
		'richness',
		'right',
		'rotation',
		'rotation-point',
		'ruby-align',
		'ruby-overhang',
		'ruby-position',
		'ruby-span',
		'size',
		'speak',
		'speak-header',
		'speak-numeral',
		'speak-punctuation',
		'speech-rate',
		'stress',
		'string-set',
		'tab-side',
		'table-layout',
		'target',
		'target-name',
		'target-new',
		'target-position',
		'text-align',
		'text-align-last',
		'text-decoration',
		'text-emphasis',
		'text-height',
		'text-indent',
		'text-justify',
		'text-outline',
		'text-replace',
		'text-shadow',
		'text-transform',
		'text-wrap',
		'top',
		'unicode-bibi',
		'vertical-align',
		'visibility',
		'voice-balance',
		'voice-duration',
		'voice-family',
		'voice-pitch',
		'voice-pitch-range',
		'voice-rate',
		'voice-stress',
		'voice-volume',
		'volume',
		'white-space',
		'white-space-collapse',
		'widows',
		'width',
		'word-break',
		'word-spacing',
		'word-wrap',
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
		$this->_keys[] = $string;
		$this->_keys[] = array(
			'start'	=> $this->_properties,
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
