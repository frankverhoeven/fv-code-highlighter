<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

interface Factory
{
    /**
     * Create new container item
     *
     * @param Container $container     Container object.
     * @param string    $requestedName Name of the requested entry.
     *
     * @return mixed
     */
    public function __invoke(Container $container, string $requestedName);
}
