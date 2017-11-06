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
	 * Cache dir
	 * @var string
	 */
	protected $cacheDir;

    /**
     * __construct()
     *
     * @param string $cacheDir
     * @version 20171103
     */
	public function __construct($cacheDir)
    {
		$this->setCacheDir(realpath($cacheDir) . '/');
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
		if ($handle = fopen($this->getCacheDir() . $name, 'w+')) {
			fwrite($handle, $content);
			fclose($handle);
		}

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
