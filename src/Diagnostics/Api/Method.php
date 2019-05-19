<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics\Api;

final class Method
{
    /** @var string */
    private $method;

    private function __construct(string $method)
    {
        $this->method = $method;
    }

    public static function get(): self
    {
        return new self('GET');
    }

    public static function post(): self
    {
        return new self('POST');
    }

    public function __toString(): string
    {
        return $this->method;
    }
}
