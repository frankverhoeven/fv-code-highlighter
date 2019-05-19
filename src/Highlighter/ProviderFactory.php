<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;

final class ProviderFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Provider
    {
        return new Provider($container, $container->get(LanguageMap::class));
    }
}
