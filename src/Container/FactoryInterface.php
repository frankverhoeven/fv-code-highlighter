<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

/**
 * FactoryInterface
 */
interface FactoryInterface
{
    /**
     * Create new container object
     *
     * @param Container $container     Container object.
     * @param string    $requestedName Name of the requested entry.
     *
     * @return mixed
     */
    public function create(Container $container, string $requestedName);
}
