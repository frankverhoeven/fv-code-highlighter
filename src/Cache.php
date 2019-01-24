<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Cache
{
    /** @var string */
    private $cacheDirectory;

    /** @var bool */
    private $enabled;

    /**
     * Create a new cache handler with the provided cache directory.
     *  Caching is automatically disabled if the given directory is not
     *  writable or WP_DEBUG is set to true.
     */
    public function __construct(string $cacheDirectory)
    {
        $this->cacheDirectory = \realpath($cacheDirectory) . '/';

        if (\wp_is_writable($cacheDirectory) && WP_DEBUG !== true) {
            return;
        }

        $this->enabled = false;
    }

    /**
     * Check if the cache file exists.
     *  Returns false if cache is disabled.
     */
    public function cacheFileExists(string $filename) : bool
    {
        return $this->enabled && \file_exists($this->cacheDirectory . $filename);
    }

    public function clear()
    {
        if (! $this->enabled) {
            return;
        }

        $handle = \opendir($this->cacheDirectory);

        if ($handle === false) {
            return;
        }

        while (($file = \readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            \unlink($this->cacheDirectory . $file);
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

        \file_put_contents($this->cacheDirectory . $filename, $content);
    }

    /**
     * Get the content of a cache file.
     *  Returns null if cache is disabled.
     *  An InvalidArgumentException is thrown if the cache file does not exist.
     *
     * @throws \InvalidArgumentException
     */
    public function getCacheFile(string $filename)
    {
        if (! $this->enabled) {
            return null;
        }
        if (! $this->cacheFileExists($filename)) {
            throw new \InvalidArgumentException('The requested cache file does not exist');
        }

        return \file_get_contents($this->cacheDirectory . $filename);
    }

    public function generateHash(string $code, string $language) : string
    {
        return \sha1($code . $language);
    }
}
