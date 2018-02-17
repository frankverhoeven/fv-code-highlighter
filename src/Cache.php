<?php

namespace FvCodeHighlighter;

use InvalidArgumentException;

/**
 * Cache
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Cache
{
	/**
	 * @var string
	 */
	protected $cacheDirectory;
    /**
     * @var bool
     */
	protected $enabled;

    /**
     * Create a new cache handler with the provided cache directory.
     *  Caching is automatically disabled if the given directory is not
     *  writable or WP_DEBUG is set to true.
     *
     * @param string $cacheDirectory
     */
	public function __construct($cacheDirectory)
    {
		$this->cacheDirectory = \realpath($cacheDirectory) . '/';

		if (!\wp_is_writable($cacheDirectory) || true === WP_DEBUG) {
		    $this->enabled = false;
        }
	}

	/**
	 * Check if the cache file exists.
     *  Returns false if cache is disabled.
	 *
	 * @param string $filename
	 * @return bool
	 */
	public function cacheFileExists($filename)
    {
		return $this->enabled && \file_exists($this->cacheDirectory . $filename);
	}

	/**
	 * Create a new cache file if cache is enabled.
	 *
	 * @param string $filename
	 * @param string $content
	 */
	public function createCacheFile($filename, $content)
    {
        if ($this->enabled) {
            \file_put_contents($this->cacheDirectory . $filename, $content);
        }
	}

    /**
     * Get the content of a cache file.
     *  Returns null if cache is disabled.
     *  An InvalidArgumentException is thrown if the cache file does not exist.
     *
     * @param string $filename
     * @return string|null
     * @throws InvalidArgumentException
     */
	public function getCacheFile($filename)
    {
        if (!$this->enabled) {
            return null;
        }
        if (!$this->cacheFileExists($filename)) {
			throw new InvalidArgumentException('The requested cache file does not exist');
		}

		return \file_get_contents($this->cacheDirectory . $filename);
	}

	/**
	 * Clear the entire cache by removing all files in the cache directory.
	 *
	 * @return void
	 */
	public function clear()
    {
        if ($this->enabled && $handle = \opendir($this->cacheDirectory)) {
            while (false !== ($file = \readdir($handle))) {
                if ('.' != $file && '..' != $file) {
                    \unlink($this->cacheDirectory . $file);
                }
            }

            \closedir($handle);
        }
	}
}
