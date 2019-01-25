<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics;

use FvCodeHighlighter\Diagnostics\Api\Data;
use FvCodeHighlighter\Diagnostics\Api\Method;
use FvCodeHighlighter\Diagnostics\Api\Request;
use FvCodeHighlighter\Diagnostics\Api\Url;

final class Code
{
    public static function diagnose(string $code, string $language)
    {
        $hash      = \sha1($code);
        $submitted = \get_option('fvch-diagnostics-snippets', []);

        if (\in_array($hash, $submitted)) {
            return;
        }

        $request = new Request(Url::codes(), Method::post());

        try {
            $request->sendRequest(Data::code($code, $language));
        } catch (\RuntimeException $exception) {
            return;
        }

        $submitted[] = $hash;
        \update_option('fvch-diagnostics-snippets', $submitted);
    }
}
