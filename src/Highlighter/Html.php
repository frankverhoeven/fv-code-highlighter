<?php

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Key;
use FvCodeHighlighter\Parser\Parser;

/**
 * Html
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Html extends AbstractHighlighter
{
	protected $keys = [
		[
			'start'	=> '<!--',
			'end'	=> '-->',
			'css'	=> 'html-comment'
        ],
    ];

	/**
	 * highlight()
	 *
	 * @return $this
	 */
	public function highlight() {
		$attribute = new Key([
			'start'	=> ['"', "'"],
			'end'	=> '@match',
			'css'	=> 'html-attribute'
        ]);
		$this->keys[] = [
			'start'	=> ['<form', '</form', '<input', '<select', '</select', '<option', '</option', '<textarea', '</textarea', '<button', '</button'],
			'end'	=> '>',
			'css'	=> 'html-form-element',
			'sub'	=> [$attribute]
        ];
		$this->keys[] = [
			'start'	=> ['<a', '</a'],
            'startSuf'  => '[^a-zA-Z]',
			'end'	=> '>',
			'css'	=> 'html-anchor-element',
			'sub'	=> [$attribute]
        ];
		$this->keys[] = [
			'start'	=> '<img',
			'end'	=> '>',
			'css'	=> 'html-image-element',
			'sub'	=> [$attribute]
        ];
		$this->keys[] = [
			'start'	=> ['<script', '</script'],
			'end'	=> '>',
			'css'	=> 'html-script-element',
			'sub'	=> [$attribute]
        ];
		$this->keys[] = [
			'start'	=> ['<style', '</style'],
			'end'	=> '>',
			'css'	=> 'html-style-element',
			'sub'	=> [new Key([
				'start'	=> ['"', "'"],
				'end'	=> '@match',
				'css'	=> 'css-string'
            ])]
        ];
		$this->keys[] = [
			'start'	=> ['<table', '</table', '<tbody', '</tbody', '<thead', '</thead', '<tfoot', '</tfoot', '<th', '</th', '<tr', '</tr', '<td', '</td'],
			'end'	=> '>',
			'css'	=> 'html-table-element',
			'sub'	=> [$attribute]
        ];
		$this->keys[] = [
			'start'	=> '<',
			'end'	=> '>',
			'css'	=> 'html-other-element',
			'sub'	=> [$attribute]
        ];
		$this->keys[] = [
			'start'	=> '&',
			'end'	=> [';', "\n", ' ', "\t"],
			'css'	=> 'html-special-char'
        ];


		foreach ($this->keys as $i=>$key) {
			if (!($key instanceof Key)) {
				$this->keys[ $i ] = new Key($key);
			}
		}

		$parser = new Parser($this->getCode());

		$parser->setKeys($this->keys)
			   ->parse();

		$code = $parser->getParsedCode();

		preg_match_all('/&lt;style(.*?)&gt;(?<code>.*?)&lt;\/style&gt;/msi', $code, $cssCode);
		for ($i=0; $i<count($cssCode[0]); $i++) {
			$highlighter = new Css(htmlspecialchars_decode(strip_tags($cssCode['code'][$i])));
			$highlighter->highlight();

			$code = str_replace($cssCode['code'][$i], '<span class="css">' . $highlighter->getCode() . '</span>', $code);
		}
		preg_match_all('/style=<span class="html-attribute">&quot;(?<code>.*?)&quot;<\/span>/msi', $code, $cssCode);
		for ($i=0; $i<count($cssCode[0]); $i++) {
			$highlighter = new Css(htmlspecialchars_decode(strip_tags($cssCode['code'][$i])));
			$highlighter->highlight();
			$code = str_replace($cssCode['code'][$i], '<span class="css">' . $highlighter->getCode() . '</span>', $code);
		}

		preg_match_all('/&lt;script(.*?)&gt;(?<code>.*?)&lt;\/script&gt;/msi', $code, $jsCode);
		for ($i=0; $i<count($jsCode[0]); $i++) {
			$highlighter = new Javascript(htmlspecialchars_decode(strip_tags($jsCode['code'][$i])));
			$highlighter->highlight();

			$code = str_replace($jsCode['code'][$i], '<span class="js">' . $highlighter->getCode() . '</span>', $code);
		}


		$this->setCode($code);

		return $this;
	}
}
