<?php

namespace FvCodeHighlighter\Container;

use InvalidArgumentException;

/**
 * Container
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Container
{
    /**
     * @var array
     */
    private $container;
    /**
     * @var array
     */
    private $factories;

    /**
     * __construct()
     *
     * @param array $factories
     * @version 20171118
     */
    public function __construct(array $factories)
    {
        $this->container = [];
        $this->factories = $factories;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     * @return mixed Entry.
     * @version 20171118
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new InvalidArgumentException('Entry "' . $id . '" not found.');
        }

        if (!array_key_exists($id, $this->container)) {
            $entry = $this->factories[$id];

            if (is_string($entry) && class_exists($entry)) {
                $entry = new $entry();
            }

            if ($entry instanceof FactoryInterface) {
                $this->container[$id] = $entry->create($this);
            } else {
                $this->container[$id] = $entry;
            }
        }

        return $this->container[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     * @return bool
     * @version 20171118
     */
    public function has($id)
    {
        return (array_key_exists($id, $this->factories) || array_key_exists($id, $this->container));
    }
}