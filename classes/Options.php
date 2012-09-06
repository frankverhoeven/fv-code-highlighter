<?php

/**
 * FvCodeHighlighter_Options
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Options
{
	/**
	 * @var array
	 */
	protected $_defaultOptions	= array();

	/**
	 * @var array
	 */
	protected $_options			= array();

	/**
	 * __construct()
	 *
	 * @version 20120710
	 * @return void
	 */
	public function __construct()
	{
		$this->_setDefaultOptions();
	}

	/**
	 * _setDefaultOptions()
	 *
	 * @version 20120710
	 * @return FvCodeHighlighter_Options
	 */
	protected function _setDefaultOptions()
	{
		$this->_defaultOptions = array(
			'fvch_version'          => FvCodeHighlighter_Version::getVersion(),
			'fvch-cache-dir'        => realpath(dirname(__FILE__) . '/../cache'),
			'fvch-font-family'      => 'Monaco',
			'fvch-font-size'        => '11',
			'fvch-background'       => 'notepaper',
            'fvch-background-custom'=> '#f6f6f6',
			'fvch-line-numbers'     => '1',
            'fvch-toolbox'          => '0'
		);

		return $this;
	}

	/**
	 * getDefaultOptions()
	 *
	 * @version 20120710
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return $this->_defaultOptions;
	}

	/**
	 * getDefaultOption()
	 *
	 * @version 20120716
	 * @param string $key
	 * @return mixed
	 */
	public function getDefaultOption($key)
	{
		if (!isset($this->_defaultOptions[ $key ])) {
			return null;
		}

		return $this->_defaultOptions[ $key ];
	}

	/**
	 * addOptions()
	 *
	 * @version 20120710
	 * @return FvCodeHighlighter_Options
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
	 * @version 20120710
	 * @param string $key
	 * @param mixed $value
	 * @return FvCodeHighlighter_Options
	 */
	public function addOption($key, $value)
	{
		add_option($key, $value);
		$this->_options[ $key ] = $value;

		return $this;
	}

	/**
	 * updateOption()
	 *
	 * @version 20120716
	 * @param string $key
	 * @param mixed $value
	 * @return FvCodeHighlighter_Options
	 */
	public function updateOption($key, $value)
	{
		update_option($key, $value);
		$this->_options[ $key ] = $value;

		return $this;
	}

	/**
	 * getOption()
	 *
	 * @version 20120716
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function getOption($key, $default=null)
	{
		if (isset($this->_options[ $key ])) {
			return $this->_options[ $key ];
		}

		if (null === $default) {
			return $this->_options[ $key ] = get_option($key, $this->getDefaultOption($key));
		}

		return $this->_options[ $key ] = get_option($key, $default);
	}

	/**
	 * deleteOptions()
	 *
	 * @version 20120710
	 * @return FvCodeHighlighter_Options
	 */
	public function deleteOptions()
	{
		foreach ($this->getDefaultOptions() as $key=>$value) {
			$this->deleteOption($key);
		}

		return $this;
	}

	/**
	 * deleteOption()
	 *
	 * @version 20120710
	 * @param string $key
	 * @return FvCodeHighlighter_Options
	 */
	public function deleteOption($key)
	{
		delete_option($key);
		unset($this->_options[ $key ]);

		return $this;
	}
}

