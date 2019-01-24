<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser;

final class Pointer
{
    /** @var int */
    private $pointer;

    public function __construct(int $pointer)
    {
        $this->pointer = $pointer;
    }

    public static function zero() : self
    {
        return new self(0);
    }

    public function increase(int $amount = 1)
    {
        $this->pointer += $amount;
    }

    public function isGreaterThan(int $amount) : bool
    {
        return $this->pointer > $amount;
    }

    public function isSmallerThan(int $amount) : bool
    {
        return $this->pointer < $amount;
    }

    public function isZero() : bool
    {
        return $this->pointer === 0;
    }

    public function toInt() : int
    {
        return $this->pointer;
    }
}
