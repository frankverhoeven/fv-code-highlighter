<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Hook;

use FvCodeHighlighter\Output\Formatter\Formatter;
use FvCodeHighlighter\Output\Formatter\Options;

final class Highlighter implements Hook
{
    /** @var Formatter */
    private $highlighter;

    public function __construct(Formatter $highlighter)
    {
        $this->highlighter = $highlighter;
    }

    /**
     * @param mixed $arguments
     */
    public function __invoke(...$arguments): string
    {
        $content = $arguments[0];

        if (\strpos($content, '{code') === false &&
            \strpos($content, '[code') === false &&
            \strpos($content, '<pre') === false
        ) {
            return $content;
        }

        $defaultSettings = ['type' => ''];

        $patterns = [
            '/\<pre(?<arguments>.*?)\>(?<code>.*?)\<\/pre\>/msi',
            '/\{code(?<arguments>.*?)\}(?<code>.*?)\{\/code\}/msi',
            '/\[code(?<arguments>.*?)\](?<code>.*?)\[\/code\]/msi',
        ];

        foreach ($patterns as $pattern) {
            \preg_match_all($pattern, $content, $codes);
            $num = \count($codes[0]);

            for ($i = 0; $i < $num; $i++) {
                $settings = [];
                $options  = \explode(' ', $codes['arguments'][$i]);

                foreach ($options as $option) {
                    $settings = \array_merge($settings, \wp_parse_args($option, $defaultSettings));
                }

                if ((!isset($settings['type']) || $settings['type'] === '') && isset($settings['lang'])) {
                    $settings['type'] = $settings['lang'];
                }
                $settings['type'] = \trim($settings['type'], '"\'');

                $content = \str_replace(
                    $codes[0][$i],
                    $this->highlighter->format($codes['code'][$i], new Options($settings['type'])),
                    $content
                );
            }
        }

        return $content;
    }
}
