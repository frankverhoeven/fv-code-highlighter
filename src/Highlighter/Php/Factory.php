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
     * @return mixed
     */
    public function create(Container $container)
    {
        $elements = [
            Block::create([
                'start'	=> ['/*'],
                'end'	=> ['*/'],
                'cssClass'	=> 'php-comment'
            ]),
            Block::create([
                'start'	=> ['//', '#'],
                'end'	=> ["\n", "?>"],
                'cssClass'	=> 'php-comment',
                'includeEnd' => false
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
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Key::create(['<?php', '<?=', '<?', '?>'], 'php-script-tag'),
            Block::create([
                'start'	=> ['$'],
                'end'	=> array_merge(Php::$whitespace, Php::$operators, Php::$brackets, [',', ';']),
                'cssClass'	=> 'php-var',
                'endIncluded'	=> false
            ]),
            Key::create(Php::$operators, 'php-operator'),
            Key::create(Php::$numbers, 'php-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
            Key::create(Php::$brackets, 'php-brackets'),
            Key::create(Php::$varTypes, 'php-var-type', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(Php::$constants, 'php-constant', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(Php::$keywords, 'php-keyword', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(get_defined_functions()['internal'], 'php-function', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
        ];

        return new Php($elements);
    }
}
