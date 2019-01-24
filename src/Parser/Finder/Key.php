<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser\Finder;

final class Key extends Finder
{
    /** @var string[] */
    private $keys;

    /**
     * @param string[] $keys
     */
    public function __construct(array $keys)
    {
        $this->keys = $keys;
    }

    public function find(string $code, int $pointer) : bool
    {
        foreach ($this->keys as $key) {
            if (\strncmp($code, $key, \strlen($key)) === 0) {
                $this->result = $key;
                return true;
            }
        }

        return false;
    }
}
