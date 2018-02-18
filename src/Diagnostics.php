<?php

namespace FvCodeHighlighter;

/**
 * Diagnostics
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class Diagnostics
{
    /**
     * @var string
     */
    const API_DIAGNOSTICS_CODES = 'https://api.frankverhoeven.me/fvch/1.0/codes';

    /**
     * Submit a code snippet for diagnostics
     *
     * @param string $language
     * @param string $code
     * @return void
     */
    public static function submitCodeSnippet(string $language, string $code): void
    {
        $hash = \sha1($code);
        $submitted = \get_option('fvch-diagnostics-snippets', []);

        if (!\in_array($hash, $submitted)) {
            \wp_remote_post(self::API_DIAGNOSTICS_CODES, [
                'blocking' => false,
                'body' => [
                    'blog_url' => \get_bloginfo('url'),
                    'language' => $language,
                    'code'     => $code,
                ],
            ]);

            $submitted[] = $hash;
            \update_option('fvch-diagnostics-snippets', $submitted);
        }
    }
}
