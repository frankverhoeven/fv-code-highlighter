<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;
use FvCodeHighlighter\Parser\Parser;

abstract class AbstractHighlighter implements Highlighter
{
    /** @var string[] List of whitespace [ \n\t] */
    public static $whitespace = [
        ' ',
        "\n",
        "\t",
    ];

    /** @var string[] List of number [0-9] */
    public static $numbers = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
    ];

    /** @var string[] List of operators */
    public static $operators = [
        '=',
        '+',
        '/',
        '*',
        '&',
        '^',
        '%',
        ':',
        '?',
        '!',
        '-',
        '<',
        '>',
        '|',
        '~',
        '.',
        ' and ',
        ' or ',
        ' xor ',
    ];

    /** @var string[] List of Brackets */
    public static $brackets = [
        '{',
        '}',
        '[',
        ']',
        '(',
        ')',
    ];

    /** @var string[] List of valid method name chars */
    public static $methodChars = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '_',
    ];

    /** @var Block[]|Key[] */
    protected $elements;

    /** @var Parser */
    protected $parser;

    /**
     * @param Block[]|Key[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function highlight(string $code): string
    {
        if ($this->parser === null) {
            $this->setup();
        }

        $code = $this->preProcess($code);
        $code = $this->parser->parse($code);
        $code = $this->postProcess($code);

        return $code;
    }

    public function preProcess(string $code): string
    {
        return $code;
    }

    public function postProcess(string $code): string
    {
        return $code;
    }

    public function setup()
    {
        $this->parser = Parser::createWithElements($this->elements);
    }

    /**
     * @return Block[]|Key[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
