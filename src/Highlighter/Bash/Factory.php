<?php

namespace FvCodeHighlighter\Highlighter\Bash;

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
                'start'	=> ['#'],
                'end'	=> ["\n"],
                'cssClass'	=> 'php-comment',
                'includeEnd' => false
            ]),
            Block::create([
                'start'	=> ['"'],
                'end'	=> ['"'],
                'cssClass'	=> 'bash-string',
                'endPrefix'=> '.*(?<!\\\)$|[\\\]{2}',
                'endPrefixLength' => 2,
            ]),
            Block::create([
                'start'	=> ["'"],
                'end'	=> ["'"],
                'cssClass'	=> 'bash-string',
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
