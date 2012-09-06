<?php

/**
 * FvCodeHighlighter_Loader_Autoloader
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Loader_Autoloader
{
	const CLASS_PREFIX = 'FvCodeHighlighter';
	const CLASS_SEPARATOR = '_';

	/**
	 * Root directory
	 * @var string
	 */
	protected $_root;

	/**
	 * File loader
	 * @var FvCodeHighlighter_Loader_Interface
	 */
	protected $_loader;

	/**
	 * Constructor.
	 *
	 * @param string $root Root directory.
	 * @param FvCodeHighlighter_Loader_Interface $loader File loader
	 */
	public function __construct($root, FvCodeHighlighter_Loader_Interface $loader)
	{
		$this->_root = $root;
		$this->_loader = $loader;
	}

	/**
	 * Register the autoloader.
	 *
	 * @return \FvCodeHighlighter_Loader_Autoloader
	 */
	public function register()
	{
		spl_autoload_register(array($this, 'autoload'));
		return $this;
	}

	/**
	 * Convert a classname to the corresponding filename.
	 *
	 * @param string $className
	 * @return string
	 */
	public function convertClassNameToFilename($className)
	{
		return str_replace(
			self::CLASS_PREFIX,
			'',
			str_replace(self::CLASS_SEPARATOR, DIRECTORY_SEPARATOR, $className)
		) . '.php';
	}

	/**
	 * Autoloader
	 *
	 * @param string $className
	 * @return bool
	 */
	public function autoload($className)
	{
		if (false === strpos($className, self::CLASS_PREFIX)) return;

		$file = $this->convertClassNameToFilename($className);

		try {
			$this->_loader->loadFile($this->_root . $file);
		} catch (Exception $e) {
			return false;
		}

		return true;
	}
}

