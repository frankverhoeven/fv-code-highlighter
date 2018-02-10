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
     */
	public function __construct(Options $options, Cache $cache)
	{
		$this->options = $options;
        $this->cache = $cache;
    }

	/**
	 * Checks if an install is needed.
	 *
	 * @return bool
	 */
	public function isInstall()
	{
		return ! (bool) $this->options->getOption('fvch_version', false);
	}

	/**
	 * Check if an update is needed.
	 *
	 * @return bool
	 */
	public function isUpdate()
	{
		return (1 == version_compare($this->options->getDefaultOption('fvch_version'), $this->options->getOption('fvch_version')));
	}

    /**
     * Install.
     *
     * @return $this
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
     */
    public function update()
    {
        $this->options
            ->addOptions()
            ->updateOption('fvch_version', $this->options->getDefaultOption('fvch_version'));

        // Migrate font-size from px to em
        if ((float) $this->options->getOption('fvch-font-size') > 2) {
            $this->options->updateOption('fvch-font-size', $this->options->getDefaultOption('fvch-font-size'));
        }

        $this->cache->clear();

        return $this;
    }

    /**
     * Check if an update is available.
     *
     * @return bool
     */
    public function hasUpdate()
    {
        $lastCheck = $this->options->getOption('fvch-previous-has-update', false);
        if (!$lastCheck || (time() - $lastCheck) > 86400) { // Only check once every 24 hours
            $latest = Version::getLatestVersion();
            $this->options->updateOption('fvch-previous-has-update', time());

            if (null !== $latest) {
                return (1 == version_compare($latest, $this->options->getOption('fvch_version')));
            }
        }

        return false;
	}
}
