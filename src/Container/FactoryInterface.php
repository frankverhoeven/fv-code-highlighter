<?php

namespace FvCodeHighlighter\Container;

/**
 * FactoryInterface
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
interface FactoryInterface
{
    /**
     * Create new container object
     *
     * @param Container $container
     * @return mixed
     */
    public function create(Container $container);
}
