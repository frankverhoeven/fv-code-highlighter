<?php

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Key;
use FvCodeHighlighter\Parser\Parser;

/**
 * Css
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Css extends AbstractHighlighter
{
	protected $properties = [
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
    ];

	protected $keys = [
		[
			'start'	=> '/*',
			'end'	=> '*/',
			'css'	=> 'css-comment'
        ],
    ];

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
			'css'	=> 'css-string',
			'endPre'=> '[^\\\]'
        ]);
		$important = new Key([
			'start'	=> '!important',
			'css'	=> 'css-important'
        ]);
		$this->keys[] = [
			'start'	=> $this->properties,
            'startPre'  => '[^a-zA-Z-:]',
			'end'	=> [';', '}'],
			'includeEnd'	=> false,
			'css'	=> 'css-property',
			'sub'	=> [
			    new Key([
                    'start'	=> ':',
                    'end'	=> [';', '}'],
                    'css'	=> 'css-value',
                    'includeStart'	=> false,
                    'includeEnd'	=> false,
                    'sub'	=> [$string, $important]
                ])
            ]
        ];
		$this->keys[] = [
			'start'	=> '@import',
			'end'	=> [';', "\n"],
			'css'	=> 'css-import',
			'sub'	=> [$string]
        ];
		$this->keys[] = [
			'start'	=> '@media',
			'end'	=> '{',
			'css'	=> 'css-media'
        ];

		foreach ($this->keys as $i=>$key) {
			if (!($key instanceof Key)) {
				$this->keys[ $i ] = new Key($key);
			}
		}

		$parser = new Parser($this->getCode());

		$parser->setKeys($this->keys)
			   ->parse();

		// Fixes
		$code = str_replace(':<span class="css-value">', '<span class="css-selector">:</span><span class="css-value">', $parser->getParsedCode());
		$code = preg_replace('/\}(\s*?)\}/', '}\\1<span class="css-media">}</span>', $code);

		$this->setCode('<span class="css">' . $code . '</span>');

		return $this;
	}
}
