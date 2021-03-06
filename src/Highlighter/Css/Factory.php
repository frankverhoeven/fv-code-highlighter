<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Css;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory as FactoryInterface;
use FvCodeHighlighter\Highlighter\Php\Php;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Factory implements FactoryInterface
{
    public function __invoke(Container $container, string $requestedName): Css
    {
        $php = Block::create([
            'start' => ['<?php', '<?=', '<?'],
            'end'   => ['?>'],
            'cssClass'  => 'php',
            'children' => $container->get(Php::class)->getElements(),
            'highlightWithChildren' => true,
        ]);

        $string = [
            Block::create([
                'start' => ['"'],
                'end'   => ['"'],
                'cssClass'  => 'css-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start' => ["'"],
                'end'   => ["'"],
                'cssClass'  => 'css-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            $php,
        ];

        $important = Key::create(['!important'], 'css-important');

        $value = Block::create([
            'start' => [':'],
            'end'   => [';', '}'],
            'cssClass'  => 'css-value',
            'startIncluded' => false,
            'endIncluded'   => false,
            'children'  => \array_merge($string, [$important, $php]),
        ]);

        $elements = [
            Block::create([
                'start' => ['/*'],
                'end'   => ['*/'],
                'cssClass'  => 'css-comment',
                'children' => [$php],
            ]),
            Block::create([
                'start' => Css::$properties,
                'startPrefix' => '^(?![a-zA-Z-:]).*$',
                'end'   => [';', '}'],
                'endIncluded' => false,
                'cssClass'  => 'css-property',
                'children' => [$value, $php],
            ]),
            Block::create([
                'start' => ['@import'],
                'end'   => [';', "\n"],
                'cssClass'  => 'css-import',
                'children' => $string,
            ]),
            Block::create([
                'start' => ['@media'],
                'end'   => ['{'],
                'cssClass'  => 'css-media',
                'children' => [$php],
            ]),
        ];

        return new Css($elements);
    }
}
