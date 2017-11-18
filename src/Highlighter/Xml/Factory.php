<?php

namespace FvCodeHighlighter\Highlighter\Xml;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\FactoryInterface;
use FvCodeHighlighter\Highlighter\Php\Php;
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
        $php = Block::create([
            'start'	=> ['<?php', '<?=', '<?'],
            'end'	=> ['?>'],
            'cssClass'	=> 'php',
            'children' => $container->get(Php::class)->getElements(),
            'highlightWithChildren' => true,
        ]);

        $xmlAttribute = [
            Block::create([
                'start'	=> ['"'],
                'end'	=> ['"'],
                'cssClass'	=> 'xml-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
                'children' => [$php],
            ]),
            Block::create([
                'start'	=> ["'"],
                'end'	=> ["'"],
                'cssClass'	=> 'xml-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
                'children' => [$php],
            ]),
            $php
        ];

        $elements = [
            $php,
            Block::create([
                'start'	=> ['<!--'],
                'end'	=> ['-->'],
                'cssClass'	=> 'xml-comment',
                'children' => [$php],
            ]),
            Block::create([
                'start'	=> ['<'],
                'startSuf' => '^(?!\?).*$',
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'xml-element',
                'children'	=> $xmlAttribute,
            ]),
            Key::create(Xml::$numbers, 'xml-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
        ];

        return new Xml($elements);
    }
}
