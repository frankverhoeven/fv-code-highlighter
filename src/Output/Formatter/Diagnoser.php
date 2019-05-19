<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

use FvCodeHighlighter\Config;
use FvCodeHighlighter\Diagnostics\Code;

final class Diagnoser implements Formatter
{
    /** @var Config */
    private $config;

    /** @var Code */
    private $diagnostics;

    /** @var Formatter */
    private $innerHighlighter;

    public function __construct(
        Code $diagnostics,
        Config $config,
        Formatter $innerHighlighter
    ) {
        $this->diagnostics      = $diagnostics;
        $this->config           = $config;
        $this->innerHighlighter = $innerHighlighter;
    }

    public function format(string $code, Options $options): string
    {
        if ($this->config->get('fvch-diagnostics', false)) {
            $this->diagnostics->diagnose($code, $options->language());
        }

        return $this->innerHighlighter->format($code, $options);
    }
}
