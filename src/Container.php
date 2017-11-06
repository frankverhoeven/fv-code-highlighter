<?php

namespace FvCodeHighlighter;

/**
 * FvCodeHighlighter_Container
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Container
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $objects = [];

    /**
     * @var Container
     */
    protected static $instance;

    /**
     * __construct()
     *
     * @param array $options
     * @version 20171103
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * setInstance()
     *
     * @param Container $instance
     * @version 20171103
     */
    public static function setInstance(Container $instance=null)
    {
        if (null === self::$instance) {
            if (null === $instance) {
                self::$instance = new Container();
            } else {
                self::$instance = $instance;
            }
        }
    }

    /**
     * getInstance()
     *
     * @return Container
     * @version 20171103
     */
    public static function getInstance()
    {
        self::setInstance();
        return self::$instance;
    }

	/**
	 * Get options object.
	 *
	 * @return Options
     * @version 20171103
	 */
	public function getOptions()
	{
		if (isset($this->objects['options'])) {
			return $this->objects['options'];
		}

		return $this->objects['options'] = new Options();
	}

	/**
	 * Get cacher.
	 *
	 * @return Cache
     * @version 20171103
	 */
	public function getCache()
	{
		if (isset($this->objects['cache'])) {
			return $this->objects['cache'];
		}

		return $this->objects['cache'] = new Cache(
			$this->getOptions()->getOption('fvch-cache-dir')
		);
	}
}
