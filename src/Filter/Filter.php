<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

// phpcs:disable Generic.NamingConventions.ConstructorName.OldStyle

interface Filter
{
    public function filter(string $value): string;
}
