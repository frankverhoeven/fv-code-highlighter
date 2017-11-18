<?php

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Element\Block;
use FvCodeHighlighter\Parser\Element\Key;
use FvCodeHighlighter\Parser\Parser;

/**
 * AbstractHighlighter
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
abstract class AbstractHighlighter implements HighlighterInterface
{
    /**
     * @var array List of whitespace [ \n\t]
     */
    public static $whitespace = [
        ' ', "\n", "\t"
    ];

    /**
     * @var array List of number [0-9]
     */
    public static $numbers = [
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    ];

    /**
     * @var array List of operators
     */
    public static $operators = [
        '=', '+', '/', '*', '&', '^', '%', ':', '?', '!', '-', '<', '>', '|', '~', '`', '~', '.', ' and ', ' or ', ' xor '
    ];

    /**
     * @var array List of Brackets
     */
    public static $brackets = [
        '{', '}', '[', ']', '(', ')'
    ];

    /**
     * @var Block[]|Key[]
     */
    protected $elements;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * Setup Highlighter
     *
     * @param Block[]|Key[] $elements
     */
    public function __construct(array $elements)
    {

    }

    /**
     * Highlight provided code
     *
     * @param string $code
     * @return string
     */
    public function highlight($code)
    {
        if (null === $this->parser) {
            $this->setup();
        }

        $code = $this->parser->parse($code);
        $code = $this->postProcess($code);

        return $code;
    }

    /**
     * Code post processing
     *
     * @param string $code
     * @return string
     */
    public function postProcess($code)
    {
        return $code;
    }

    /**
     * Setup highlighter elements
     *
     */
    public function setup()
    {
        $this->parser = Parser::createWithElements($this->elements);
    }

    /**
     * @return Block[]|Key[]
     */
    public function getElements()
    {
        return $this->elements;
    }
}
