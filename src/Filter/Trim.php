<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

final class Trim implements Filter
{
    public function filter(string $value): string
    {
        return \trim($value);
    }
}
