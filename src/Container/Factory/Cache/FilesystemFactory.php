<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Cache;

use FvCodeHighlighter\Cache\Filesystem;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;

final class FilesystemFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Filesystem
    {
        /** @var Config $config */
        $config   = $container->get(Config::class);
        $cacheDir = $config->get('fvch-cache-dir');

        if ($cacheDir === '' || !\is_dir($cacheDir)) {
            $cacheDir = $config->getDefault('fvch-cache-dir');
        }

        return new Filesystem($cacheDir);
    }
}
