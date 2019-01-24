<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\General;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory as FactoryInterface;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Factory implements FactoryInterface
{
    public function __invoke(Container $container, string $requestedName) : General
    {
        $elements = [
            Block::create([
                'start' => ['"'],
                'end'   => ['"'],
                'cssClass'  => 'general-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start' => ["'"],
                'end'   => ["'"],
                'cssClass'  => 'general-string',
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
