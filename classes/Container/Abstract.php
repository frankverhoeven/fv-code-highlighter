<?php

/**
 * FvCodeHighlighter_Container_Abstract
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
abstract class FvCodeHighlighter_Container_Abstract
{
	/**
	 * @var array
	 */
	protected $_options = array();

	/**
	 * @var array
	 */
	protected $_objects = array();

	/**
	 * @var FvCommunityNews_Container
	 */
	protected static $_instance;

	/**
	 * __construct()
	 *
	 * @version 20120709
	 * @param array $options
	 */
	public function __construct(array $options=array())
	{
		$this->_options = $options;
	}

	/**
	 * setInstance()
	 *
	 * @version 20120710
	 * @param FvCodeHighlighter_Container_Abstract $instance
	 */
	public static function setInstance(FvCodeHighlighter_Container_Abstract $instance=null)
	{
		if (null === self::$_instance) {
			if (null === $instance) {
				self::$_instance = new FvCodeHighlighter_Container();
			} else {
				self::$_instance = $instance;
			}
		}
	}

	/**
	 * getInstance()
	 *
	 * @version 20120710
	 * @return FvCodeHighlighter_Container
	 */
	public static function getInstance()
	{
		self::setInstance();
		return self::$_instance;
	}
}

