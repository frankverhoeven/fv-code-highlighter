<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Hook;

use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Hook\Header;

final class HeaderFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Header
    {
        return new Header($container->get(Config::class));
    }
}
