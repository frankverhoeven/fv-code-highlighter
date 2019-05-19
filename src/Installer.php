<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter\Cache\Cache;

final class Installer
{
    /** @var Cache */
    private $cache;

    /** @var Config */
    private $config;

    public function __construct(Cache $cache, Config $config)
    {
        $this->cache  = $cache;
        $this->config = $config;
    }

    public function isInstall(): bool
    {
        return $this->config->get('fvch_version') === null;
    }

    public function isUpdate(): bool
    {
        return \version_compare(Version::getCurrentVersion(), $this->config->get('fvch_version')) === 1;
    }

    public function install()
    {
    }

    public function update()
    {
        if ($this->config->get('fvch_version') === '2.1.2') {
            $this->config->delete('fvch-diagnostics-snippets');
        }

        $this->config->set('fvch_version', Version::getCurrentVersion());

        // Migrate font-size from px to em
        if ((float) $this->config->get('fvch-font-size') > 2) {
            $this->config->set('fvch-font-size', $this->config->getDefault('fvch-font-size'));
        }

        $this->cache->clear();
    }

    public function hasUpdate(): bool
    {
        $lastCheck = $this->config->get('fvch-previous-has-update');
        if ($lastCheck === null || (\time() - $lastCheck) > 86400) { // Only check once every 24 hours
            $latest = Version::getLatestVersion();
            $this->config->set('fvch-previous-has-update', \time());

            if ($latest !== null) {
                return \version_compare($latest, $this->config->get('fvch_version')) === 1;
            }
        }

        return false;
    }
}
