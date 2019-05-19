<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics\Api;

final class Url
{
    const BASE = 'https://api.frankverhoeven.me/fvch/1.0/';

    /** @var string */
    private $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function codes(): self
    {
        return new self(self::BASE . 'codes');
    }

    public static function errors(): self
    {
        return new self(self::BASE . 'errors');
    }

    public static function latestVersion(): self
    {
        return new self(self::BASE . 'versions/latest');
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
