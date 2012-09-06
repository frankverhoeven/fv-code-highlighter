<?php

/**
 * FvCodeHighlighter_Installer
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Installer
{
	/**
	 *	Options
	 *	@var FvCodeHighlighter_Options
	 */
	protected $_options;

	/**
	 *		__construct()
	 *
	 *		@return void
	 */
	public function __construct()
	{
		$this->_options = FvCodeHighlighter_Container::getInstance()->getOptions();
	}

	/**
	 * Install.
	 *
	 * @return \FvCodeHighlighter_Installer
	 */
	public function doInstall()
	{
		$this->_options->addOptions();
		return $this;
	}

	/**
	 * Update.
	 *
	 * @return \FvCodeHighlighter_Installer
	 */
	public function doUpdate()
	{
		$this->_options
			->addOptions()
			->updateOption('fvch_version', $this->_options->getOption('fvch_version'));

		FvCodeHighlighter_Container::getInstance()->getCache()->clear();

		return $this;
	}

	/**
	 * Checks if an install is needed.
	 *
	 * @return bool
	 */
	public function isInstall()
	{
		return ! (bool) $this->_options->getOption('fvch_version', false);
	}

	/**
	 * Check if an update is needed.
	 *
	 * @return bool
	 */
	public function isUpdate()
	{
		return (1 == version_compare($this->_options->getDefaultOption('fvch_version'), $this->_options->getOption('fvch_version')));
	}
}

