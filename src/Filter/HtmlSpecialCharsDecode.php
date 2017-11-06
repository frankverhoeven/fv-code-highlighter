<?php

namespace FvCodeHighlighter\Filter;

/**
 * HtmlSpecialCharsDecode
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class HtmlSpecialCharsDecode implements FilterInterface
{
    /**
     * Safe htmlspecialchars_decode().
     *
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $converted = false;

        $checks = [
            '&amp;amp;',
            '&lt;?php',
            '&lt;/'
        ];

        foreach ($checks as $check) {
            if (strstr($value, $check)) {
                $converted = true;
            }
        }

        if ($converted) {
            return htmlspecialchars_decode($value);
        } else {
            return $value;
        }
    }
}
