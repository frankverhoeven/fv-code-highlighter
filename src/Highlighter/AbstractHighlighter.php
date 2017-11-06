<?php

namespace FvCodeHighlighter\Highlighter;

/**
 * AbstractHighlighter
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
abstract class AbstractHighlighter {
	
	/**
	 * @var string
	 */
	protected $code;
	
	/**
	 * __construct()
	 *
	 * @param string $code
	 */
	public function __construct($code=null)
    {
		$this->setCode($code);
	}
	
	/**
	 * setCode()
	 *
	 * @param string $code
	 * @return $this
	 */
	public function setCode($code)
    {
		$this->code = (string) $code;
		return $this;
	}
	
	/**
	 * getCode()
	 *
	 * @return string
	 */
	public function getCode()
    {
		return $this->code;
	}
	
	/**
	 * highlight()
	 *
	 * @return $this
	 */
	abstract public function highlight();
	
	/**
	 * getHighlightedCode()
	 *
	 * @param string $code
	 * @return string
	 */
	public function getHighlightedCode($code)
    {
		return $this->setCode($code)->highlight()->getCode();
	}
}
