<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Cache
{
    /** @var string */
    private $directory;

    /** @var bool */
    private $enabled;

    public function __construct(string $directory)
    {
        $this->directory = \realpath($directory) . '/';
        $this->enabled   = \WP_DEBUG === false && \wp_is_writable($this->directory);
    }

    public function clear(): bool
    {
        if (!$this->enabled) {
            return true;
        }

        $handle = \opendir($this->directory);

        if ($handle === false) {
            return false;
        }

        $success = true;

        while (($file = \readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $success = \unlink($this->directory . $file) && $success;
        }

        \closedir($handle);

        return $success;
    }

    /**
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if (!$this->enabled || !$this->has($key)) {
            return $default;
        }

        return \file_get_contents($this->directory . $key);
    }

    public function has(string $key): bool
    {
        return $this->enabled && \file_exists($this->directory . $key);
    }

    /**
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        if (!$this->enabled) {
            return;
        }

        \file_put_contents($this->directory . $key, $value);
    }
}
