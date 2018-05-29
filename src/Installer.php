<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

/**
 * Installer
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class Installer
{
	/**
	 * @var Config
	 */
	private $config;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * __construct()
     *
     * @param Config $config
     * @param Cache $cache
     */
	public function __construct(Config $config, Cache $cache)
	{
		$this->config = $config;
        $this->cache = $cache;
    }

	/**
	 * Checks if an install is needed.
	 *
	 * @return bool
	 */
	public function isInstall(): bool
	{
		return null === $this->config['fvch_version'];
	}

	/**
	 * Check if an update is needed.
	 *
	 * @return bool
	 */
	public function isUpdate(): bool
	{
		return (1 == \version_compare(Version::getCurrentVersion(), $this->config['fvch_version']));
	}

    /**
     * Install.
     *
     * @return Installer
     */
    public function install(): self
    {
        return $this;
    }

    /**
     * Update.
     *
     * @return Installer
     */
    public function update(): self
    {
        if ('2.1.2' === $this->config['fvch_version']) {
            $this->config->delete('fvch-diagnostics-snippets');
        }

        $this->config->set('fvch_version', Version::getCurrentVersion());

        // Migrate font-size from px to em
        if ((float) $this->config['fvch-font-size'] > 2) {
            $this->config->set('fvch-font-size', $this->config->getDefault('fvch-font-size'));
        }

        $this->cache->clear();

        return $this;
    }

    /**
     * Check if an update is available.
     *
     * @return bool
     */
    public function hasUpdate(): bool
    {
        $lastCheck = $this->config['fvch-previous-has-update'];
        if (null === $lastCheck || (\time() - $lastCheck) > 86400) { // Only check once every 24 hours
            $latest = Version::getLatestVersion();
            $this->config->set('fvch-previous-has-update', \time());

            if (null !== $latest) {
                return (1 == \version_compare($latest, $this->config['fvch_version']));
            }
        }

        return false;
	}
}
