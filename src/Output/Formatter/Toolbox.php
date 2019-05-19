<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

use FvCodeHighlighter\Config;

final class Toolbox implements Formatter
{
    /** @var Config */
    private $config;

    /** @var Formatter */
    private $innerHighlighter;

    public function __construct(Config $config, Formatter $innerHighlighter)
    {
        $this->config           = $config;
        $this->innerHighlighter = $innerHighlighter;
    }

    public function format(string $code, Options $options): string
    {
        $parsed = $this->innerHighlighter->format($code, $options);

        if ($this->config->get('fvch-toolbox')) {
            $parsed = \str_replace(
                '<div class="fvch-codeblock">',
                '<div class="fvch-codeblock">' . $this->toolbox(),
                $parsed
            );
        }

        return $parsed;
    }

    private function toolbox(): string
    {
        return <<<HTML
<div class="fvch-hide-if-no-js fvch-toolbox">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fvch-toolbox-icon fvch-toolbox-icon-select">
        <path d="M433.941 65.941l-51.882-51.882A48 48 0 0 0 348.118 0H176c-26.51
            0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48
            48 48h224c26.51 0 48-21.49 48-48v-48h80c26.51 0 48-21.49 48-48V99.882a48
            48 0 0 0-14.059-33.941zM266 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h74v224c0
            26.51 21.49 48 48 48h96v42a6 6 0 0 1-6 6zm128-96H182a6 6 0 0 1-6-6V54a6
            6 0 0 1 6-6h106v88c0 13.255 10.745 24 24 24h88v202a6 6 0 0 1-6
            6zm6-256h-64V48h9.632c1.591 0 3.117.632 4.243 1.757l48.368 48.368a6
            6 0 0 1 1.757 4.243V112z">
        </path>
    </svg>
</div>
HTML;
    }
}
