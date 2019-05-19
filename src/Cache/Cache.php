<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Cache;

interface Cache
{
    /**
     * Clear entire cache
     */
    public function clear();

    /**
     * Get a single cache item, or default if not found
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $filename, $default = null);

    /**
     * Whether the cache item exists
     */
    public function has(string $filename): bool;

    /**
     * Create a new cache item
     *
     * @param mixed $content
     */
    public function set(string $filename, $content);
}
