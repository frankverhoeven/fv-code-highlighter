<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

interface Formatter
{
    public function format(string $code, Options $options): string;
}
