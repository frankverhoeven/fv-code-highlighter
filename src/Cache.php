<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Cache
{
    /** @var string */
    private $directory;

    /** @var bool */
    private $enabled;

    /**
     * Create a new cache handler with the provided cache directory.
     *  Caching is automatically disabled if the given directory is not
     *  writable or WP_DEBUG is set to true.
     */
    public function __construct(string $directory)
    {
        $this->directory = \realpath($directory) . '/';
        $this->enabled   = \WP_DEBUG === false && \wp_is_writable($directory);
    }

    /**
     * Check if the cache file exists.
     *  Returns false if cache is disabled.
     */
    public function has(string $filename): bool
    {
        return $this->enabled && \file_exists($this->directory . $filename);
    }

    public function clear()
    {
        if (! $this->enabled) {
            return;
        }

        $handle = \opendir($this->directory);

        if ($handle === false) {
            return;
        }

        while (($file = \readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            \unlink($this->directory . $file);
        }

        \closedir($handle);
    }

    /**
     * Create a new cache file if cache is enabled.
     */
    public function createCacheFile(string $filename, string $content)
    {
        if (! $this->enabled) {
            return;
        }

        \file_put_contents($this->directory . $filename, $content);
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $filename, $default = null)
    {
        if (!$this->enabled || !$this->has($filename)) {
            return $default;
        }

        return \file_get_contents($this->directory . $filename);
    }

    public function generateHash(string $code, string $language): string
    {
        return \sha1($code . $language);
    }
}
