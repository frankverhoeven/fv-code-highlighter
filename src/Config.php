<?php

namespace FvCodeHighlighter;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Config
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class Config implements ArrayAccess, Countable, Iterator
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config = null)
    {
        if (null !== $config) {
            foreach ($config as $key => $value) {
                if (\is_array($value)) {
                    $this->config[$key] = new static($value);
                } else {
                    $this->config[$key] = $value;
                }
            }
        }
    }

    /**
     * Retrieve a value and return $default if there is no element set.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if (\array_key_exists($key, $this->config)) {
            $default = $this->config[$key];
        }

        return \get_option($key, $default);
    }

    /**
     * Retreive the default value for $key, null if no default.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getDefault(string $key)
    {
        $default = null;
        if (\array_key_exists($key, $this->config)) {
            $default = $this->config[$key];
        }

        return $default;
    }

    /**
     * Add a value to the config, skips if key exists.
     *
     * @param  string $key
     * @param  mixed  $value
     */
    public function add(string $key, $value)
    {
        if (\is_array($value)) {
            $value = new static($value);
        }

        if (!\array_key_exists($key, $this->config)) {
            $this->config[$key] = $value;
        }
        \add_option($key, $value);
    }

    /**
     * Set a value in the config.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        if (\is_array($value)) {
            $value = new static($value);
        }

        $this->config[$key] = $value;
        \update_option($key, $value);
    }

    /**
     * Whether an option exists.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }

    /**
     * Delete an option
     *
     * @param string $key
     */
    public function delete(string $key)
    {
        if (isset($this->config[$key])) {
            unset($this->config[$key]);
            \delete_option($key);
        }
    }

    /**
     * Whether a offset exists
     *
     * @param mixed $offset An offset to check for.
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset The offset to retrieve.
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Offset to unset
     *
     * @param mixed $offset The offset to unset.
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    /**
     * Return the current element
     *
     * @return mixed Can return any type.
     */
    public function current()
    {
        return \current($this->config);
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        \next($this->config);
    }

    /**
     * Return the key of the current element
     *
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return \key($this->config);
    }

    /**
     * Checks if current position is valid
     *
     * @return boolean Returns true on success or false on failure.
     */
    public function valid(): bool
    {
        return ($this->key() !== null);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        \reset($this->config);
    }

    /**
     * Count elements of an object
     *
     * @return int The custom count as an integer.
     */
    public function count(): int
    {
        return \count($this->config);
    }
}
