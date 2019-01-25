<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Javascript;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory as FactoryInterface;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Factory implements FactoryInterface
{
    public function __invoke(Container $container, string $requestedName): Javascript
    {
        $elements = [
            Block::create([
                'start' => ['/*'],
                'end'   => ['*/'],
                'cssClass'  => 'js-comment',
            ]),
            Block::create([
                'start' => ['//', '#'],
                'end'   => ["\n"],
                'cssClass'  => 'js-comment',
                'includeEnd' => false,
            ]),
            Block::create([
                'start' => ['"'],
                'end'   => ['"'],
                'cssClass'  => 'js-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start' => ["'"],
                'end'   => ["'"],
                'cssClass'  => 'js-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),/* @todo: fix
            Block::create([
            'start' => ['/'],
            'end'   => ['/'],
            'cssClass' => 'js-regexp',
            'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}', // gimuy
            'endPrefixLength' => 2,
            ]),*/
            Key::create(['=', '+', '/', '*', '&', '^', '%', ':', '?', '!', '-', '<', '>', '|'], 'js-operator'),
            Key::create(Javascript::$numbers, 'js-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
            Key::create(Javascript::$brackets, 'js-brackets'),
            Key::create(['function'], 'js-function-keyword', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(Javascript::$reservedKeywords, 'js-reserved-keyword', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(Javascript::$clientKeywords, 'js-client-keyword', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
            Key::create(Javascript::$nativeKeyword, 'js-native-keyword', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
        ];

        return new Javascript($elements);
    }
}
