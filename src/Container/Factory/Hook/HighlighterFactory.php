<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Hook;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Hook\Highlighter;
use FvCodeHighlighter\Output\Formatter\Formatter;

final class HighlighterFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Highlighter
    {
        return new Highlighter($container->get(Formatter::class));
    }
}
