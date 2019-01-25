<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

final class Chain implements Filter
{
    /** @var Filter[] */
    private $filters;

    /**
     * @param Filter[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = (static function (Filter ...$filter) {
            return $filter;
        })(...$filters);
    }

    public function filter(string $value): string
    {
        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }

        return $value;
    }
}
