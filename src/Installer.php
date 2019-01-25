<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Installer
{
    /** @var Config */
    private $config;

    /** @var Cache */
    private $cache;

    public function __construct(Config $config, Cache $cache)
    {
        $this->config = $config;
        $this->cache  = $cache;
    }

    public function isInstall(): bool
    {
        return $this->config['fvch_version'] === null;
    }

    public function isUpdate(): bool
    {
        return \version_compare(Version::getCurrentVersion(), $this->config['fvch_version']) === 1;
    }

    public function install(): self
    {
        return $this;
    }

    public function update(): self
    {
        if ($this->config['fvch_version'] === '2.1.2') {
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

    public function hasUpdate(): bool
    {
        $lastCheck = $this->config['fvch-previous-has-update'];

        if ($lastCheck === null || (\time() - $lastCheck) > 86400) { // Only check once every 24 hours
            $latest = Version::getLatestVersion();
            $this->config->set('fvch-previous-has-update', \time());

            if ($latest !== null) {
                return \version_compare($latest, $this->config['fvch_version']) === 1;
            }
        }

        return false;
    }
}
