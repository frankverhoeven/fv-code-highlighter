<?php

namespace FvCodeHighlighter;

/**
 * Version
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class Version
{
	/**
	 * Current Version
	 * @var string
	 */
	private static $version = '1.9';

	/**
	 * Get the current plugin version.
	 *
	 * @return string
     * @version 20171103
	 */
	public static function getVersion()
	{
		return self::$version;
	}
}
