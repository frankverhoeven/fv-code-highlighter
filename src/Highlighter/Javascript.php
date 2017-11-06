<?php

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Key;
use FvCodeHighlighter\Parser\Parser;

class Javascript extends AbstractHighlighter
{
	protected $reservedKeywords = [
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
    ];
	
	protected $clientKeywords = [
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
    ];
	
	protected $nativeKeyword = [
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
    ];
	
	
	protected $keys = [
		[
			'start'	=> '/*',
			'end'	=> '*/',
			'css'	=> 'js-comment'
        ],
		[
			'start'	=> '//',
			'end'	=> "\n",
			'css'	=> 'js-comment',
			'includeEnd'	=> false
        ],
		[
			'start'	=> ['"', "'"],
			'end'	=> '@match',
			'css'	=> 'js-string',
			'endPre'=> '[^\\\]'
        ],
		/*array(
			'start'	=> '/',
			'end'	=> '/',
			'css'	=> 'js-regexp',
			'endPre'=> '[^\\\]'
		),*/
		[
			'start'	=> ['=', '+', '/', '*', '&', '^', '%', ':', '?', '!', '-', '<', '>', '|'],
			'css'	=> 'js-operator'
        ],
		[
			'start'	=> ['{', '}', '[', ']', '(', ')'],
			'css'	=> 'js-bracket'
        ],
		[
			'start'	=> ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
			'css'	=> 'js-number'
        ],
		[
			'start'	=> 'function',
			'css'	=> 'js-function-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
        ],
    ];
	
	/**
	 * highlight()
	 *
	 * @return $this
	 */
	public function highlight()
    {
		$this->keys[] = [
			'start'	=> $this->reservedKeywords,
			'css'	=> 'js-reserved-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
        ];
		$this->keys[] = [
			'start'	=> $this->clientKeywords,
			'css'	=> 'js-client-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
        ];
		$this->keys[] = [
			'start'	=> $this->nativeKeyword,
			'css'	=> 'js-native-keyword',
			'startPre'	=> '[^a-zA-Z0-9_]',
			'startSuf'	=> '[^a-zA-Z0-9_]'
        ];
		
		foreach ($this->keys as $i=>$key) {
			if (!($key instanceof Key)) {
				$this->keys[ $i ] = new Key($key);
			}
		}
		
		$parser = new Parser($this->getCode());
		
		$parser->setKeys($this->keys)
			   ->parse();
		
		
		$this->setCode('<span class="js">' . $parser->getParsedCode() . '</span>');
		
		return $this;
	}
}
