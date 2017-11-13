<?php

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Parser\Key;
use FvCodeHighlighter\Parser\Parser;

/**
 * General
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class General extends AbstractHighlighter
{
    protected $operators = [
        '=', '+', '/', '*', '&', '^', '%', ':', '?', '!', '-', '<', '>', '|', '~', '`', '~', '.', ' and ', ' or ', ' xor '
    ];

    protected $brackets = [
        '{', '}', '[', ']', '(', ')'
    ];

    protected $numbers = [
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    ];

    /**
     * @var array
     */
    protected $keys = [
        [
            'start'	=> ['"', "'"],
            'end'	=> '@match',
            'css'	=> 'general-string',
            'endPre'=> '[^\\\]'
        ],
    ];

    /**
     * highlight()
     *
     * @return $this
     */
    public function highlight()
    {
        $this->keys[] = [
            'start'	=> $this->operators,
            'css'	=> 'general-operator'
        ];
        $this->keys[] = [
            'start'	=> $this->numbers,
            'css'	=> 'general-number',
            'startPre' => '[^a-zA-Z]',
        ];
        $this->keys[] = [
            'start'	=> $this->brackets,
            'css'	=> 'general-brackets'
        ];

        foreach ($this->keys as $i=>$key) {
            if (!($key instanceof Key)) {
                $this->keys[ $i ] = new Key($key);
            }
        }

        $parser = new Parser($this->getCode());

        $parser->setKeys($this->keys)
            ->parse();


        $this->setCode($parser->getParsedCode());

        return $this;
    }
}
