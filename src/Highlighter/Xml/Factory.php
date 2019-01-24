<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Xml;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory as FactoryInterface;
use FvCodeHighlighter\Highlighter\Php\Php;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Factory implements FactoryInterface
{
    public function __invoke(Container $container, string $requestedName) : Xml
    {
        $php = Block::create([
            'start' => ['<?php', '<?=', '<?'],
            'end'   => ['?>'],
            'cssClass'  => 'php',
            'children' => $container->get(Php::class)->getElements(),
            'highlightWithChildren' => true,
        ]);

        $xmlAttribute = [
            Block::create([
                'start' => ['"'],
                'end'   => ['"'],
                'cssClass'  => 'xml-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
                'children' => [$php],
            ]),
            Block::create([
                'start' => ["'"],
                'end'   => ["'"],
                'cssClass'  => 'xml-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
                'children' => [$php],
            ]),
            $php,
        ];

        $elements = [
            $php,
            Block::create([
                'start' => ['<!--'],
                'end'   => ['-->'],
                'cssClass'  => 'xml-comment',
                'children' => [$php],
            ]),
            Block::create([
                'start' => ['<'],
                'startSuf' => '^(?!\?).*$',
                'end'   => ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'  => 'xml-element',
                'children'  => $xmlAttribute,
            ]),
            Key::create(Xml::$numbers, 'xml-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
        ];

        return new Xml($elements);
    }
}
