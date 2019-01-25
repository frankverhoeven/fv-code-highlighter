<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Diagnostics
{
    const API_DIAGNOSTICS_CODES = 'https://api.frankverhoeven.me/fvch/1.0/codes';

    public static function submitCodeSnippet(string $language, string $code)
    {
        $hash      = \sha1($code);
        $submitted = \get_option('fvch-diagnostics-snippets', []);

        if (\in_array($hash, $submitted)) {
            return;
        }

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
