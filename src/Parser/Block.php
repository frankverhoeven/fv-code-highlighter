<?php

namespace FvCodeHighlighter\Parser;

/**
 * Block
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Block extends Parser
{
	/**
	 * @var string
	 */
	protected $start;
	/**
	 * @var string
	 */
	protected $end;
	/**
	 * @var string
	 */
	protected $cssClass;
	
	/**
	 * init()
	 *
	 * @param array $options
	 */
	public function init(array $options = null)
    {
		if (null !== $options) {
			$this->setOptions($options);
		}
	}
	
	/**
	 * setOptions()
	 *
	 * @param array $options
	 */
	public function setOptions(array $options)
    {
		$methods = get_class_methods($this);
		
		foreach ($options as $key=>$value) {
			$func = 'set' . $key;
			
			if (in_array($func, $methods)) {
				$this->$func($value);
			}
		}
	}
	
	/**
	 * setStart()
	 *
	 * @param string $start
	 */
	public function setStart($start)
    {
		$this->start = (string) $start;
	}
	
	/**
	 * getStart()
	 *
	 * @return string
	 */
	public function getStart()
    {
		return $this->start;
	}
	
	/**
	 * setEnd()
	 *
	 * @param string $end
	 */
	public function setEnd($end)
    {
		$this->end = (string) $end;
	}
	
	/**
	 * getEnd()
	 *
	 * @return string
	 */
	public function getEnd()
    {
		return $this->end;
	}
	
	/**
	 * setCssClass()
	 *
	 * @param string $class
	 */
	public function setCssClass($class)
    {
		$this->cssClass = (string) $class;
	}
	
	/**
	 * getCssClass()
	 *
	 * @return string
	 */
	public function getCssClass()
    {
		return $this->cssClass;
	}
}
