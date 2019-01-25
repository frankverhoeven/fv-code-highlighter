<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

final class InvokableFactory implements Factory
{
    /**
     * @return mixed
     */
    public function __invoke(Container $container, string $requestedName)
    {
        return new $requestedName();
    }
}
