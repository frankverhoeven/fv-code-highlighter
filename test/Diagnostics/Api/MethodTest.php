<?php

declare(strict_types=1);

namespace FvCodeHighlighterTest\Diagnostics\Api;

use FvCodeHighlighter\Diagnostics\Api\Method;
use PHPUnit\Framework\TestCase;

final class MethodTest extends TestCase
{
    public function testPost()
    {
        self::assertEquals(
            'POST',
            (string) Method::post()
        );
    }

    public function testGet()
    {
        self::assertEquals(
            'GET',
            (string) Method::get()
        );
    }
}
