<?php

namespace FvCodeHighlighter;

/**
 * Installer
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Installer
{
	/**
	 * Options
	 * @var Options
	 */
	protected $options;

    /**
     * __construct()
     *
     * @version 20171103
     */
	public function __construct()
	{
		$this->options = Container::getInstance()->getOptions();
	}

	/**
	 * Install.
	 *
     * @return $this
     * @version 20171103
	 */
	public function doInstall()
	{
		$this->options->addOptions();
		return $this;
	}

    /**
     * Update.
     *
     * @return $this
     * @version 20171103
     */
	public function doUpdate()
	{
		$this->options
			->addOptions()
			->updateOption('fvch_version', $this->options->getOption('fvch_version'));

		Container::getInstance()->getCache()->clear();

		return $this;
	}

	/**
	 * Checks if an install is needed.
	 *
	 * @return bool
     * @version 20171103
	 */
	public function isInstall()
	{
		return ! (bool) $this->options->getOption('fvch_version', false);
	}

	/**
	 * Check if an update is needed.
	 *
	 * @return bool
     * @version 20171103
	 */
	public function isUpdate()
	{
		return (1 == version_compare($this->options->getDefaultOption('fvch_version'), $this->options->getOption('fvch_version')));
	}
}
