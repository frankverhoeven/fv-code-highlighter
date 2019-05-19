<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

use FvCodeHighlighter\Filter\Filter;

final class Filtered implements Formatter
{
    /** @var Filter */
    private $filter;

    /** @var Formatter */
    private $innerHighlighter;

    public function __construct(Filter $filter, Formatter $innerHighlighter)
    {
        $this->filter           = $filter;
        $this->innerHighlighter = $innerHighlighter;
    }

    public function format(string $code, Options $options): string
    {
        return $this->innerHighlighter->format(
            $this->filter->filter($code),
            $options
        );
    }
}
