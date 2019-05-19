<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

final class HtmlSpecialCharsDecode implements Filter
{
    /**
     * Safe htmlspecialchars_decode().
     */
    public function filter(string $value): string
    {
        $converted = false;

        $checks = [
            '&amp;amp;',
            '&lt;?php',
            '&lt;/',
        ];

        foreach ($checks as $check) {
            if (\strpos($value, $check) === false) {
                continue;
            }

            $converted = true;
        }

        if ($converted) {
            return \htmlspecialchars_decode($value);
        }

        return $value;
    }
}
