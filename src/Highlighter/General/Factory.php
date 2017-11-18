<?php

namespace FvCodeHighlighter\Highlighter\General;

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
                'start'	=> ['"'],
                'end'	=> ['"'],
                'cssClass'	=> 'general-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> ["'"],
                'end'	=> ["'"],
                'cssClass'	=> 'general-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Key::create(General::$operators, 'general-operator'),
            Key::create(General::$numbers, 'general-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
            Key::create(General::$brackets, 'general-brackets'),
        ];

        return new General($elements);
    }
}
