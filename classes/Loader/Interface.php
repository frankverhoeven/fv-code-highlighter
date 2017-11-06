<?php

/**
 * FvCodeHighlighter_Loader_Interface
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
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

