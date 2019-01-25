<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

final class Container
{
    /** @var mixed[] */
    private $container;

    /** @var Factory[]|string[] */
    private $factories;

    /**
     * @param Factory[]|string[] $factories
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
     *
     * @return mixed Entry.
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new \InvalidArgumentException('Entry "' . $id . '" not found.');
        }

        if (!\array_key_exists($id, $this->container)) {
            $entry = $this->factories[$id];

            if (\is_string($entry) && \class_exists($entry)) {
                $entry = new $entry();
            }

            if ($entry instanceof Factory) {
                $this->container[$id] = $entry($this, $id);
            } else {
                $this->container[$id] = $entry;
            }
        }

        return $this->container[$id];
    }

    public function has(string $id): bool
    {
        return \array_key_exists($id, $this->factories) || \array_key_exists($id, $this->container);
    }

    /**
     * @param Factory|mixed $entry
     *
     * @return void
     */
    public function add(string $id, $entry)
    {
        if ($this->has($id)) {
            throw new \InvalidArgumentException('An entry for "' . $id . '" already exists.');
        }

        $this->factories[$id] = $entry;
    }
}
