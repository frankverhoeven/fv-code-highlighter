<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

use FvCodeHighlighter\Config;

final class LineNumbers implements Formatter
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
        $code = $this->innerHighlighter->format($code, $options);

        if ($this->config->get('fvch-line-numbers')) {
            $code = $this->addLineNumbers($code);
        }

        return $code;
    }

    private function addLineNumbers(string $code): string
    {
        $withLines = '';
        $lines     = \explode('<tr>', $code);
        $lastLine  = \array_pop($lines);

        foreach ($lines as $index => $line) {
            $withLines .= $line . \sprintf(
                '<tr><td class="fvch-line-number" data-line-number="%d"></td>',
                $index + 1
            );
        }

        return $withLines . $lastLine;
    }
}
