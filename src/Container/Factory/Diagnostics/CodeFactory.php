<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Diagnostics;

use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Diagnostics\Code;

final class CodeFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Code
    {
        return new Code($container->get(Config::class));
    }
}
