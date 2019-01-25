<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

interface Filter
{
    public function filter(string $value): string;
}
