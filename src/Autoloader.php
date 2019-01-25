<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Autoloader
{
    /** @var string[] */
    private $prefixes;

    /**
     * @param string[] $prefixes Array with prefixes as keys and their PSR-4 compatible paths as values.
     */
    public function __construct(array $prefixes)
    {
        foreach ($prefixes as $prefix => $path) {
            $this->setPrefix($prefix, $path);
        }
    }

    public function setPrefix(string $prefix, string $path)
    {
        $this->prefixes[$prefix] = $path;
    }

    public function register(bool $prepend = false)
    {
        \spl_autoload_register([$this, 'autoload'], true, $prepend);
    }

    public function unregister()
    {
        \spl_autoload_unregister([$this, 'autoload']);
    }

    public function autoload(string $class)
    {
        foreach ($this->prefixes as $prefix => $path) {
            $len = \strlen($prefix);

            if (\strncmp($prefix, $class, $len) !== 0) {
                continue;
            }

            $relativeClass = \substr($class, $len);
            $file          = $path . \str_replace('\\', '/', $relativeClass) . '.php';

            $this->loadFile($file);
        }
    }

    public function loadFile(string $file)
    {
        // Prevent access to $this
        (static function () use ($file) {
            if (!\file_exists($file)) {
                return;
            }

            require $file;
        })();
    }
}
