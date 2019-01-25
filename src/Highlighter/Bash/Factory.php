<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Bash;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory as FactoryInterface;
use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;

final class Factory implements FactoryInterface
{
    public function __invoke(Container $container, string $requestedName): Bash
    {
        $elements = [
            Block::create([
                'start' => ['#'],
                'end'   => ["\n"],
                'cssClass'  => 'php-comment',
                'includeEnd' => false,
            ]),
            Block::create([
                'start' => ['"'],
                'end'   => ['"'],
                'cssClass'  => 'bash-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start' => ["'"],
                'end'   => ["'"],
                'cssClass'  => 'bash-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Key::create(Bash::$operators, 'bash-operator'),
            Key::create(Bash::$numbers, 'bash-number', '^(?![a-zA-Z]).*$', '^(?![a-zA-Z]).*$'),
            Key::create(Bash::$brackets, 'bash-brackets'),
            Key::create(Bash::$commands, 'bash-command', '^(?![a-zA-Z0-9_]).*$', '^(?![a-zA-Z0-9_]).*$'),
        ];

        return new Bash($elements);
    }
}
