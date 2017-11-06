<?php

/**
 * FvCodeHighlighter_Version
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class FvCodeHighlighter_Version
{
	/**
	 * Current Version
	 * @var string
	 */
	private static $_version = '1.8';

	/**
	 * Get the current plugin version.
	 *
	 * @return string
	 */
	public static function getVersion()
	{
		return self::$_version;
	}
}
