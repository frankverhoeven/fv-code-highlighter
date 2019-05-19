<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Hook;

use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Hook\EnqueueScripts;

final class EnqueueScriptsFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): EnqueueScripts
    {
        return new EnqueueScripts($container->get(Config::class));
    }
}
