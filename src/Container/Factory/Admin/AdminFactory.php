<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Admin;

use FvCodeHighlighter\Admin\Admin;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;

final class AdminFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Admin
    {
        return new Admin($container->get(Config::class));
    }
}
