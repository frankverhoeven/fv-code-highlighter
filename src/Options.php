<?php

namespace FvCodeHighlighter;

/**
 * FvCodeHighlighter_Options
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Options
{
	/**
	 * @var array
	 */
	protected $defaultOptions = [];

	/**
	 * @var array
	 */
	protected $options = [];

    /**
     * __construct()
     *
     * @version 20171103
     */
	public function __construct()
	{
		$this->setDefaultOptions();
	}

	/**
	 * setDefaultOptions()
	 *
     * @return $this
     * @version 20171103
	 */
	protected function setDefaultOptions()
	{
		$this->defaultOptions = [
			'fvch_version'          => Version::getCurrentVersion(),
			'fvch-cache-dir'        => __DIR__ . '/../cache',
			'fvch-font-family'      => 'Monaco',
			'fvch-font-size'        => '11',
			'fvch-background'       => 'notepaper',
            'fvch-background-custom'=> '#f6f6f6',
			'fvch-line-numbers'     => '1',
            'fvch-toolbox'          => '0'
        ];

		return $this;
	}

	/**
	 * getDefaultOptions()
	 *
	 * @return array
     * @version 20171103
	 */
	public function getDefaultOptions()
	{
		return $this->defaultOptions;
	}

	/**
	 * getDefaultOption()
	 *
	 * @param string $key
	 * @return mixed
     * @version 20171103
	 */
	public function getDefaultOption($key)
	{
		if (!isset($this->defaultOptions[ $key ])) {
			return null;
		}

		return $this->defaultOptions[ $key ];
	}

	/**
	 * addOptions()
	 *
     * @return $this
     * @version 20171103
	 */
	public function addOptions()
	{
		foreach ($this->getDefaultOptions() as $key=>$value) {
			$this->addOption($key, $value);
		}

		return $this;
	}

    /**
     * addOption()
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     * @version 20171103
     */
	public function addOption($key, $value)
	{
		add_option($key, $value);
		$this->options[ $key ] = $value;

		return $this;
	}

    /**
     * updateOption()
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     * @version 20171103
     */
	public function updateOption($key, $value)
	{
		update_option($key, $value);
		$this->options[ $key ] = $value;

		return $this;
	}

	/**
	 * getOption()
	 *
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
     * @version 20171103
	 */
	public function getOption($key, $default=null)
	{
		if (isset($this->options[ $key ])) {
			return $this->options[ $key ];
		}

		if (null === $default) {
			return $this->options[ $key ] = get_option($key, $this->getDefaultOption($key));
		}

		return $this->options[ $key ] = get_option($key, $default);
	}

	/**
	 * deleteOptions()
	 *
     * @return $this
     * @version 20171103
	 */
	public function deleteOptions()
	{
		foreach ($this->getDefaultOptions() as $key => $value) {
			$this->deleteOption($key);
		}

		return $this;
	}

    /**
     * deleteOption()
     *
     * @param string $key
     * @return $this
     * @version 20171103
     */
	public function deleteOption($key)
	{
		delete_option($key);
		unset($this->options[ $key ]);

		return $this;
	}
}
