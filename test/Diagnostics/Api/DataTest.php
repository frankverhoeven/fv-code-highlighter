<?php

declare(strict_types=1);

namespace FvCodeHighlighterTest\Diagnostics\Api;

use FvCodeHighlighter\Diagnostics\Api\Data;
use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{
    public function testCode()
    {
        $code     = '<?php echo "hi";';
        $language = 'php';

        self::assertEquals(
            [
                'code'     => $code,
                'language' => $language,
            ],
            Data::code($code, $language)->toArray()
        );
    }

    public function testException()
    {
        $exception = 'Exception';
        $message   = 'message';
        $trace     = 'trace';

        self::assertEquals(
            [
                'exception' => $exception,
                'message'   => $message,
                'trace'     => $trace,
            ],
            Data::exception($exception, $message, $trace)->toArray()
        );
    }

    public function testVersion()
    {
        self::assertEquals([], Data::version()->toArray());
    }
}
