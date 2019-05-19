<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics;

use FvCodeHighlighter\Diagnostics\Api\Data;
use FvCodeHighlighter\Diagnostics\Api\Method;
use FvCodeHighlighter\Diagnostics\Api\Request;
use FvCodeHighlighter\Diagnostics\Api\Url;

final class Error
{
    public static function diagnose(\Throwable $exception)
    {
        $request = new Request(Url::errors(), Method::post());

        try {
            $request->sendRequest(
                Data::exception(
                    \get_class($exception),
                    $exception->getMessage(),
                    $exception->getTraceAsString()
                )
            );
        } catch (\RuntimeException $exception) {
        }
    }
}
