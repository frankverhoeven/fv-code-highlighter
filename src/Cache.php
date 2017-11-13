<?php

namespace FvCodeHighlighter;

use Exception;

/**
 * FvCodeHighlighter_Cache
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Cache
{
	/**
	 * @var string
	 */
	protected $cacheDir;

    /**
     * @var bool
     */
	protected $enabled = true;

    /**
     * __construct()
     *
     * @param string $cacheDir
     * @version 20171103
     */
	public function __construct($cacheDir)
    {
		$this->cacheDir = realpath($cacheDir) . '/';

		// Disable cache if $cacheDir is not writable, or if we're debugging
		if (!wp_is_writable($cacheDir) || true === WP_DEBUG) {
		    $this->enabled = false;
        }
	}

	/**
	 * setCacheDir()
	 *
	 * @param string $dir
	 * @return $this
     * @version 20171103
	 */
	public function setCacheDir($dir)
    {
		$this->cacheDir = $dir;
		return $this;
	}

	/**
	 * getCacheDir()
	 *
	 * @return string
     * @version 20171103
	 */
	public function getCacheDir()
    {
		return $this->cacheDir;
	}

	/**
	 * cacheFileExists()
	 *
	 * @param string $name
	 * @return bool
     * @version 20171103
	 */
	public function cacheFileExists($name)
    {
        if (!$this->enabled)
            return false;

		return file_exists($this->getCacheDir() . $name);
	}

	/**
	 * createCacheFile()
	 *
	 * @param string $name
	 * @param string $content
	 * @return $this
     * @version 20171103
	 */
	public function createCacheFile($name, $content)
    {
        if (!$this->enabled)
            return $this;

        file_put_contents($this->getCacheDir() . $name, $content);
		return $this;
	}

    /**
     * getCacheFile()
     *
     * @param string $name
     * @return string
     * @throws Exception
     * @version 20171103
     */
	public function getCacheFile($name)
    {
        if (!$this->enabled)
            return $this;

        if (!$this->cacheFileExists($name)) {
			throw new Exception('The requested cache file does not exist');
		}

		return file_get_contents($this->getCacheDir() . $name);
	}

	/**
	 * clear()
	 *
	 * @return $this
     * @version 20171103
	 */
	public function clear()
    {
        if (!$this->enabled)
            return $this;

        if ($dr = opendir($this->getCacheDir())) {
			while (false !== ($file = readdir($dr))) {
				if ('.' != $file && '..' != $file) {
					unlink($this->getCacheDir() . $file);
				}
			}

			closedir($dr);
		}

		return $this;
	}
}
