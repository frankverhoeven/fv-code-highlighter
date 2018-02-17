<?php

namespace FvCodeHighlighter\Highlighter\Php;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\FactoryInterface;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

/**
 * Factory
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Factory implements FactoryInterface
{
    /**
     * Create new container object
     *
     * @param Container $container
     * @param string $requestedName
     * @return mixed
     */
    public function create(Container $container, string $requestedName)
    {
        $elements = [
            Block::create([
                'start'	=> ['/*'],
                'end'	=> ['*/'],
                'cssClass'	=> 'php-comment',
                'children' => [Key::create(Php::$phpDoc, 'php-comment-phpdoc', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$')],
            ]),
            Block::create([
                'start'	=> ['//', '#'],
                'end'	=> ["\n", "?>"],
                'cssClass'	=> 'php-comment',
                'includeEnd' => false,
                'children' => [Key::create(Php::$phpDoc, 'php-comment-phpdoc', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$')],
            ]),
            Block::create([
                'start'	=> ['"'],
                'end'	=> ['"'],
                'cssClass'	=> 'php-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> ["'"],
                'end'	=> ["'"],
                'cssClass'	=> 'php-string',
                'endPrefix' => '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Key::create(['<?php', '<?=', '<?', '?>'], 'php-script-tag'),
            Block::create([
                'start'	=> ['$'],
                'end'	=> \array_merge(Php::$whitespace, Php::$operators, Php::$brackets, [',', ';']),
                'cssClass'	=> 'php-var',
                'endIncluded'	=> false,
            ]),
            Key::create(Php::$operators, 'php-operator'),
            Key::create(Php::$numbers, 'php-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
            Key::create(Php::$brackets, 'php-brackets'),
            Key::create(Php::$varTypes, 'php-var-type', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(\array_merge(Php::$constants, ['strict_types']), 'php-constant', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(Php::$keywords, 'php-keyword', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(\get_defined_functions()['internal'], 'php-function', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> \array_merge(Php::$whitespace, Php::$operators, [',', ';', '{', '}', '[', ']', ')', '->']),
                'contains' => '[a-zA-Z0-9_]+',
                'cssClass'	=> 'php-var',
                'endIncluded'	=> false,
                'startPrefix' => '(->)$',
                'startPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> ['('],
                'contains' => '[a-zA-Z0-9_]+',
                'cssClass'	=> 'php-method',
                'endIncluded'	=> false,
                'startPrefix' => '(->)$',
                'startPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> \array_merge(Php::$whitespace, ['{', ';', '(', ' as']),
                'cssClass'	=> 'php-class',
                'endIncluded'	=> false,
                'startPrefix' => '(use|as|class|new|namespace)[\s]+$',
                'startPrefixLength' => 10,
            ]),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> ['::'],
                'contains' => '[a-zA-Z0-9_]+',
                'cssClass'	=> 'php-class',
                'endIncluded'	=> false,
                'startPrefix' => '(\(|[\s])+$',
                'startPrefixLength' => 10,
            ]),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> ['('],
                'contains' => '[a-zA-Z0-9_]+',
                'cssClass'	=> 'php-method',
                'endIncluded'	=> false,
                'startPrefix' => '::$',
                'startPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> ['('],
                'cssClass'	=> 'php-method',
                'endIncluded'	=> false,
                'startPrefix' => '(function)[\s]+$',
                'startPrefixLength' => 9,
            ]),
            Block::create([
                'start'	=> Php::$methodChars,
                'end'	=> ['('],
                'contains' => '[a-zA-Z0-9_]+',
                'cssClass'	=> 'php-method',
                'endIncluded'	=> false,
                'startPrefix' => '[\!\(\+\-\=\*\/\&\%\^\.\<\>\?\s]+$',
                'startPrefixLength' => 1,
            ]),
        ];

        return new Php($elements);
    }
}
