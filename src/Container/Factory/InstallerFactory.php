<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory;

use FvCodeHighlighter\Cache\Cache;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Installer;

final class InstallerFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Installer
    {
        return new Installer(
            $container->get(Cache::class),
            $container->get(Config::class)
        );
    }
}
