<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

interface FilterInterface
{
    public function filter(string $value): string;
}
