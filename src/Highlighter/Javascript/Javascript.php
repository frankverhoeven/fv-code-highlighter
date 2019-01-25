<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Javascript;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;

final class Javascript extends AbstractHighlighter
{
    /** @var string[] */
    public static $reservedKeywords = [
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
        'with',
    ];

    /** @var string[] */
    public static $clientKeywords = [
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
        'window',
    ];

    /** @var string[] */
    public static $nativeKeyword = [
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
        'writeln',
    ];
}
