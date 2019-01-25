<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

interface Factory
{
    /**
     * @return mixed
     */
    public function __invoke(Container $container, string $requestedName);
}
