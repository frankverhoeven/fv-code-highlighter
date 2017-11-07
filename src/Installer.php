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
	 * @var Options
	 */
	protected $options;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * __construct()
     *
     * @param Options $options
     * @param Cache $cache
     * @version 20171107
     */
	public function __construct(Options $options, Cache $cache)
	{
		$this->options = $options;
        $this->cache = $cache;
    }

	/**
	 * Install.
	 *
     * @return $this
     * @version 20171107
	 */
	public function install()
	{
		$this->options->addOptions();
		return $this;
	}

    /**
     * Update.
     *
     * @return $this
     * @version 20171107
     */
	public function update()
	{
		$this->options
			->addOptions()
			->updateOption('fvch_version', $this->options->getDefaultOption('fvch_version'));

		$this->cache->clear();

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

    /**
     * Check if an update is available.
     *
     * @return bool
     * @version 20171107
     */
    public function hasUpdate()
    {
        $lastCheck = $this->options->getOption('fvch-previous-has-update', false);
        if (!$lastCheck || (time() - $lastCheck) > 432000) { // Only check once every five days
            $latest = Version::getLatestVersion();
            $this->options->updateOption('fvch-previous-has-update', time());

            if (null !== $latest) {
                return (1 == version_compare($latest, $this->options->getOption('fvch_version')));
            }
        }

        return false;
	}
}
