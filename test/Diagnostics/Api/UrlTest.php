<?php

declare(strict_types=1);

namespace FvCodeHighlighterTest\Diagnostics\Api;

use FvCodeHighlighter\Diagnostics\Api\Url;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{
    public function testCodes()
    {
        self::assertEquals(
            'https://api.frankverhoeven.me/fvch/1.0/codes',
            (string) Url::codes()
        );
    }

    public function testErrors()
    {
        self::assertEquals(
            'https://api.frankverhoeven.me/fvch/1.0/errors',
            (string) Url::errors()
        );
    }

    public function testLatestVersion()
    {
        self::assertEquals(
            'https://api.frankverhoeven.me/fvch/1.0/versions/latest',
            (string) Url::latestVersion()
        );
    }
}
