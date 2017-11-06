<?php

namespace FvCodeHighlighter;

/**
 * AutoLoader
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class AutoLoader
{
    private $prefixes = [];

    /**
     * Constructor
     *
     * @param array|null $prefixes Array with prefixes as keys and their PSR-4 compatible paths as values.
     */
    public function __construct(array $prefixes = null)
    {
        if (null !== $prefixes) {
            foreach ($prefixes as $prefix => $path) {
                $this->setPrefix($prefix, $path);
            }
        }
    }

    /**
     * Set a prefix, overwrites existing
     *
     * @param string $prefix Prefix
     * @param string $path PSR-4 Compatible Path
     */
    public function setPrefix($prefix, $path)
    {
        $this->prefixes[$prefix] = $path;
    }

    /**
     * Register the autoloader
     *
     * @param bool $prepend Whether to prepend to autoloader.
     */
    public function register($prepend = false)
    {
        spl_autoload_register([$this, 'autoload'], true, $prepend);
    }

    /**
     * Unregister the autoloader
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'autoload']);
    }

    /**
     * Autoloader
     *
     * @param string $class Class to load
     */
    public function autoload($class)
    {
        foreach ($this->prefixes as $prefix => $path) {
            $len = strlen($prefix);

            if (0 === strncmp($prefix, $class, $len)) {
                $relativeClass = substr($class, $len);
                $file = $path . str_replace('\\', '/', $relativeClass) . '.php';

                $this->loadFile($file);
            }
        }
    }

    /**
     * Load file
     *
     * @param string $file File to load
     */
    public function loadFile($file)
    {
        // Prevent access to $this/self
        (function() use ($file) {
            if (file_exists($file)) {
                require $file;
            }
        })();
    }
}
