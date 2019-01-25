<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser\Finder;

abstract class Finder
{
    /** @var string */
    protected $result;

    abstract public function find(string $code, int $pointer): bool;

    public function result(): string
    {
        return $this->result;
    }

    public function isValidContains(string $contains, string $char): bool
    {
        return (bool) \preg_match('/' . $contains . '/', $char);
    }

    public function isValidPrefixLiteral(
        string $code,
        int $pointer,
        string $prefix,
        int $prefixLength
    ): bool {
        return (
            $pointer === 0 ?
                '' :
                \substr($code, $pointer - $prefixLength, $prefixLength)
            ) === $prefix;
    }

    public function isValidPrefixRegex(
        string $code,
        int $pointer,
        string $prefixRegex,
        int $prefixLength
    ): bool {
        return (bool) \preg_match(
            '/' . $prefixRegex . '/',
            $pointer === 0 ? '' : \substr($code, $pointer - $prefixLength, $prefixLength)
        );
    }

    public function isValidSuffixLiteral(
        string $code,
        int $pointer,
        int $offset,
        string $suffix,
        int $suffixLength
    ): bool {
        return \substr($code, $pointer + $offset, $suffixLength) === $suffix;
    }

    public function isValidSuffixRegex(
        string $code,
        int $pointer,
        int $offset,
        string $suffixRegex,
        int $suffixLength
    ): bool {
        return (bool) \preg_match(
            '/' . $suffixRegex . '/',
            \substr($code, $pointer + $offset, $suffixLength)
        );
    }
}
