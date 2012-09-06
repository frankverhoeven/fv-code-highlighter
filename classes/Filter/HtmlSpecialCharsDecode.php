<?php

/**
 * FvCodeHighlighter_Filter_HtmlSpecialCharsDecode
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Filter_HtmlSpecialCharsDecode implements FvCodeHighlighter_Filter_Interface
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

        $checks = array(
            '&amp;amp;',
            '&lt;?php',
            '&lt;/'
        );

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
