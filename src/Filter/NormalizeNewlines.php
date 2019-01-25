<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

final class NormalizeNewlines implements Filter
{
    public function filter(string $value): string
    {
        return \str_replace(["\r\n", "\r"], "\n", $value);
    }
}
