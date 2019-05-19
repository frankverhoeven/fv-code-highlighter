<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Hook;

final class BlockHighlighter implements Hook
{
    /**
     * @param mixed ...$parameters
     */
    public function __invoke(...$parameters): string
    {
        // phpcs:disable SlevomatCodingStandard.PHP.ShortList.LongListUsed
        list($content, $block) = $parameters;

        if ($block['blockName'] !== 'core/code') {
            return $content;
        }

        $content = \str_replace(
            ['<pre class="wp-block-code"><code>', '</code></pre>'],
            ['<pre class="wp-block-code">', '</pre>'],
            $content
        );

        if (isset($block['attrs']['language'])) {
            $content = \str_replace(
                '<pre class="wp-block-code">',
                '<pre class="wp-block-code" lang="' . $block['attrs']['language'] . '">',
                $content
            );
        }

        return $content;
    }
}
