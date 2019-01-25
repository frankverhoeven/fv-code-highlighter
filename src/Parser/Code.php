<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser;

final class Code
{
    /** @var string */
    private $code;

    /** @var int */
    private $length;

    public function __construct(string $code)
    {
        $this->code   = $code;
        $this->length = \mb_strlen($code);
    }

    public function length(): int
    {
        return $this->length;
    }

    public function sub(int $start, int $length = null): string
    {
        return \mb_substr($this->code, $start, $length);
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
