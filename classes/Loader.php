<?php

/**
 * FvCodeHighlighter_Loader
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Loader implements FvCodeHighlighter_Loader_Interface
{
	/**
	 * Load a file.
	 *
	 * @param string $file The file to load.
	 * @param bool $once (optional) Whether to load it once or multiple times.
	 * @return bool
	 */
	public function loadFile($file, $once=true)
	{
		if (!file_exists($file)) {
			throw new Exception( sprintf('The file "%s" was not found', $file) );
		}

		if (true === $once) {
			return require_once $file;
		}

		return require $file;
	}
}
