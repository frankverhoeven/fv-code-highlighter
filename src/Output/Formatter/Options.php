<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

final class Options
{
    /** @var string */
    private $language;

    public function __construct(string $language)
    {
        $this->language = $language;
    }

    public function language(): string
    {
        return $this->language;
    }
}
