<?php

namespace FvCodeHighlighter\Highlighter\Html;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\FactoryInterface;
use FvCodeHighlighter\Highlighter\Css\Css;
use FvCodeHighlighter\Highlighter\Javascript\Javascript;
use FvCodeHighlighter\Highlighter\Php\Php;
use FvCodeHighlighter\Parser\Element\Block;

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
        $htmlAttribute = [
            Block::create([
                'start'	=> ['"'],
                'end'	=> ['"'],
                'cssClass'	=> 'html-attribute',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
                'children'	=> [$php],
            ]),
            Block::create([
                'start'	=> ["'"],
                'end'	=> ["'"],
                'cssClass'	=> 'html-attribute',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
                'children'	=> [$php],
            ]),
            $php,
        ];
        $cssAttribute = [
            Block::create([
                'start'	=> ['"'],
                'end'	=> ['"'],
                'cssClass'	=> 'css-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> ["'"],
                'end'	=> ["'"],
                'cssClass'	=> 'css-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
        ];

        $elements = [
            $php,
            Block::create([
                'start'	=> ['<!--'],
                'end'	=> ['-->'],
                'cssClass'	=> 'html-comment',
                'children'	=> [$php],
            ]),
            Block::create([
                'start'	=> ['<form', '</form', '<input', '<select', '</select', '<option', '</option', '<textarea', '</textarea', '<button', '</button'],
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-form-element',
                'children'	=> $htmlAttribute,
            ]),
            Block::create([
                'start'	=> ['<a', '</a'],
                'startSuffix'  => '[^a-zA-Z]',
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-anchor-element',
                'children'	=> $htmlAttribute,
            ]),
            Block::create([
                'start'	=> ['<img'],
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-image-element',
                'children'	=> $htmlAttribute,
            ]),
            Block::create([
                'start'	=> ['<script', '</script'],
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-script-element',
                'children'	=> $htmlAttribute,
            ]),
            Block::create([
                'start'	=> ['<style', '</style'],
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-style-element',
                'children'	=> $cssAttribute,
            ]),
            Block::create([
                'start'	=> ['<table', '</table', '<tbody', '</tbody', '<thead', '</thead', '<tfoot', '</tfoot', '<th', '</th', '<tr', '</tr', '<td', '</td'],
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-table-element',
                'children'	=> $htmlAttribute,
            ]),
            Block::create([
                'start'	=> ['<'],
                'startSuf' => '^(?!\?).*$',
                'end'	=> ['>'],
                'endPrefix' => '^(?!\?).*$',
                'cssClass'	=> 'html-other-element',
                'children'	=> $htmlAttribute,
            ]),
            Block::create([
                'start'	=> ['&'],
                'end'	=> [';', "\n", ' ', "\t"],
                'cssClass'	=> 'html-special-char',
            ]),
        ];

        return new Html($elements, $container->get(Css::class), $container->get(Javascript::class));
    }
}
