<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory;

use FvCodeHighlighter\Bootstrap;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Hook\BlockHighlighter;
use FvCodeHighlighter\Hook\EnqueueScripts;
use FvCodeHighlighter\Hook\Header;
use FvCodeHighlighter\Hook\Highlighter;
use FvCodeHighlighter\Installer;

final class BootstrapFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Bootstrap
    {
        return new Bootstrap(
            $container->get(BlockHighlighter::class),
            $container,
            $container->get(EnqueueScripts::class),
            $container->get(Header::class),
            $container->get(Highlighter::class),
            $container->get(Installer::class)
        );
    }
}
