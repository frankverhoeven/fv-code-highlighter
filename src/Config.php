<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

final class Config implements \ArrayAccess, \Countable, \Iterator
{
    /** @var mixed[] */
    private $config;

    /**
     * @param mixed[] $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            if (\is_array($value)) {
                $this->config[$key] = new self($value);
            } else {
                $this->config[$key] = $value;
            }
        }
    }

    /**
     * @param mixed|null $default
     *
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
     * @param mixed $value
     */
    public function add(string $key, $value)
    {
        if (\is_array($value)) {
            $value = new self($value);
        }

        if (!\array_key_exists($key, $this->config)) {
            $this->config[$key] = $value;
        }
        \add_option($key, $value);
    }

    /**
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        if (\is_array($value)) {
            $value = new self($value);
        }

        $this->config[$key] = $value;
        \update_option($key, $value);
    }

    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }

    public function delete(string $key)
    {
        if (!isset($this->config[$key])) {
            return;
        }

        unset($this->config[$key]);
        \delete_option($key);
    }

    /**
     * @param mixed $offset
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return \current($this->config);
    }

    /**
     * @return void
     */
    public function next()
    {
        \next($this->config);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return \key($this->config);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        \reset($this->config);
    }

    public function count(): int
    {
        return \count($this->config);
    }
}
