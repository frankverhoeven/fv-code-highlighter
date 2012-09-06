<?php

/**
 *	Javascript.php
 *	Highlighter_Javascript
 *
 *	Javascript Highlighter
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */


class FvCodeHighlighter_Highlighter_Javascript extends FvCodeHighlighter_Highlighter {
	
	protected $_reservedKeywords = array(
		'abstract',
		'as',
		'boolean',
		'break',
		'byte',
		'case',
		'catch',
		'char',
		'class',
		'continue',
		'const',
		'debugger',
		'default',
		'delete',
		'do',
		'double',
		'else',
		'enum',
		'export',
		'extends',
		'false',
		'final',
		'finally',
		'float',
		'for',
		'goto',
		'if',
		'implements',
		'import',
		'in',
		'instanceof',
		'int',
		'interface',
		'is',
		'long',
		'namespace',
		'native',
		'new',
		'null',
		'package',
		'private',
		'protected',
		'public',
		'return',
		'short',
		'static',
		'super',
		'switch',
		'synchronized',
		'this',
		'throw',
		'throws',
		'transient',
		'true',
		'try',
		'typeof',
		'use',
		'var',
		'void',
		'volatile',
		'while',
		'with'
	);
	
	protected $_clientKeywords = array(
		'alert',
		'all',
		'anchor',
		'back',
		'big',
		'blink',
		'blur',
		'body',
		'bold',
		'byteToString',
		'captureEvents',
		'clearInterval',
		'clearTimeout',
		'click',
		'close',
		'confirm',
		'disableExternalCapture',
		'document',
		'enableExternalCapture',
		'event',
		'find',
		'fixed',
		'focus',
		'fontcolor',
		'fontsize',
		'forward',
		'getOptionValueCount',
		'getOptionValue',
		'go',
		'handleEvent',
		'home',
		'italics',
		'javaEnabled',
		'link',
		'load',
		'log',
		'mimeTypes',
		'moveAbove',
		'moveBelow',
		'moveBy',
		'moveTo',
		'moveToAbsolute',
		'navigator',
		'open',
		'options',
		'plugins',
		'prompt',
		'refresh',
		'releaseEvents',
		'reload',
		'routeEvent',
		'screen',
		'scroll',
		'scrollBy',
		'scrollTo',
		'small',
		'stop',
		'strike',
		'sub',
		'submit',
		'sup',
		'taintEnabled',
		'unit',
		'window'
	);
	
	protected $_nativeKeyword = array(
		'abs',
		'acos',
		'Array',
		'asin',
		'atan',
		'atan2',
		'Boolean',
		'ceil',
		'charAt',
		'charCodeAt',
		'concat',
		'cos',
		'Date',
		'decodeURI',
		'decodeURIComponent',
		'encodeURI',
		'encodeURIComponent',
		'escape',
		'eval',
		'exp',
		'floor',
		'fromCharCode',
		'getDate',
		'getDay',
		'getFullYear',
		'getHours',
		'getMilliseconds',
		'getMinutes',
		'getMonth',
		'getSeconds',
		'getSelection',
		'getTime',
		'getTimezoneOffset',
		'getUTCDate',
		'getUTCDay',
		'getUTCFullYear',
		'getUTCHours',			
		'getUTCMilliseconds',      
		'getUTCMinutes',
		'getUTCMonth',
		'getUTCSeconds',      
		'getYear',
		'Image',
		'indexOf',
		'isNaN',
		'join',
		'lastIndexOf',
		'log',
		'match',
		'Math',
		'max',
		'min',
		'Number',
		'Object',
		'parse',
		'parseFloat',
		'parseInt',
		'pop',
		'pow',
		'preference',
		'print',
		'push',
		'random',
		'RegExp',
		'replace',
		'reset',
		'resizeBy',
		'resizeTo',
		'reverse',
		'round',
		'search',
		'select',
		'setDate',
		'setFullYear',
		'setHours',
		'setMilliseconds',
		'setInterval',
		'setMinutes',
		'setMonth',
		'setSeconds',
		'setTime',
		'setTimeout',
		'setUTCDate',
		'setUTCFullYear',
		'setUTCHours',
		'setUTCMilliseconds',
		'setUTCMinutes',
		'setUTCMonth',
		'setUTCSeconds',
		'setYear',
		'shift',
		'sin',
		'slice',
		'sort',
		'splice',
		'split',
		'sqrt',
		'String',
		'substr',
		'substring',
		'tan',
		'toGMTString',
		'toLocaleString',
		'toLowerCase',
		'toSource',
		'toString',
		'toUpperCase',
		'toUTCString',
		'unescape',
		'unshift',
		'unwatch',
		'UTC',
		'valueOf',
		'watch',
		'write',
		'writeln'
	);
	
	
	protected $_keys = array(
		array(
			'start'	=> '/*',
			'end'	=> '*/',
			'css'	=> 'js-comment'
		),
		array(
			'start'	=> '//',
			'end'	=> "\n",
			'css'	=> 'js-comment',
			'includeEnd'	=> false
		),
		array(
			'start'	=> array('"', "'"),
			'end'	=> '@match',
			'css'	=> 'js-string',
			'endPre'=> '[^\\\]'
		),
		/*array(
			'start'	=> '/',
			'end'	=> '/',
			'css'	=> 'js-regexp',
			'endPre'=> '[^\\\]'
		),*/
		array(
			'start'	=> array('=', '+', '/', '*', '&', '^', '%', ':', '?', '!', '-', '<', '>', '|'),
			'css'	=> 'js-operator'
		),
		array(
			'start'	=> array('{', '}', '[', ']', '(', ')'),
			'css'	=> 'js-bracket'
		),
		array(
			'start'	=> array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
			'css'	=> 'js-number'
		),
		array(
			'start'	=> 'function',
			'css'	=> 'js-function-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
		),
	);
	
	
	
	/**
	 *		highlight()
	 *
	 *		@return object $this
	 */
	public function highlight() {
		$this->_keys[] = array(
			'start'	=> $this->_reservedKeywords,
			'css'	=> 'js-reserved-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
		);
		$this->_keys[] = array(
			'start'	=> $this->_clientKeywords,
			'css'	=> 'js-client-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
		);
		$this->_keys[] = array(
			'start'	=> $this->_nativeKeyword,
			'css'	=> 'js-native-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
		);
		
		
		foreach ($this->_keys as $i=>$key) {
			if (!($key instanceof FvCodeHighlighter_Parser_Key)) {
				$this->_keys[ $i ] = new FvCodeHighlighter_Parser_Key($key);
			}
		}
		
		$parser = new FvCodeHighlighter_Parser( $this->getCode() );
		
		$parser->setKeys($this->_keys)
			   ->parse();
		
		
		$this->setCode( '<span class="js">' . $parser->getParsedCode() . '</span>' );
		
		return $this;
	}
	
}
