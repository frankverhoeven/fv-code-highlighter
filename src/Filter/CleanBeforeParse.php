<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

final class CleanBeforeParse implements Filter
{
    public function filter(string $value): string
    {
        $chain = new Chain(
            [
                new HtmlSpecialCharsDecode(),
                new Trim(),
                new NormalizeNewlines(),
                new TabsToSpaces(),
            ]
        );

        return $chain->filter($value);
    }
}
