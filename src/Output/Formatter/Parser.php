<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

use FvCodeHighlighter\Diagnostics\Error;
use FvCodeHighlighter\Highlighter\Provider;

final class Parser implements Formatter
{
    /** @var Provider */
    private $provider;

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function format(string $code, Options $options): string
    {
        try {
            return $this->provider->getHighlighter($options->language())
                ->highlight($code);
        } catch (\Throwable $exception) {
            Error::diagnose($exception);
        }

        return $code;
    }
}
