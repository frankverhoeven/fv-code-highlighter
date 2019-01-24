<?php

namespace FvCodeHighlighter\Container;

/**
 * InvokableFactory
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class InvokableFactory implements FactoryInterface
{
    /**
     * Create new container object
     *
     * @param Container $container Container object.
     * @param string $requestedName Name of the requested entry.
     * @return mixed
     */
    public function __invoke(Container $container, string $requestedName)
    {
        return new $requestedName();
    }
}
