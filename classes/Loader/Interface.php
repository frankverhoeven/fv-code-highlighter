<?php

/**
 * FvCodeHighlighter_Loader_Interface
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
interface FvCodeHighlighter_Loader_Interface
{
	/**
	 * Load a file.
	 *
	 * @param string $file The file to load.
	 * @param bool $once (optional) Whether to load it once or multiple times.
	 * @return bool
	 */
	public function loadFile($file, $once=true);
}

