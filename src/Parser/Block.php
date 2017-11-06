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
	 * Block starter
	 * @var string
	 */
	protected $start;
	
	/**
	 * Block end
	 * @var string
	 */
	protected $end;
	
	/**
	 * CSS class
	 * @var string
	 */
	protected $cssClass;
	
	/**
	 * init()
	 *
	 * @param array $options
	 * @return $this
	 */
	public function init(array $options= []) {
		if (!empty($options)) {
			$this->setOptions($options);
		}
		
		return $this;
	}
	
	/**
	 * setOptions()
	 *
	 * @param array $options
	 * @return $this
	 */
	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		
		foreach ($options as $key=>$value) {
			$func = 'set' . $key;
			
			if (in_array($func, $methods)) {
				$this->$func($value);
			}
		}
		
		return $this;
	}
	
	/**
	 * setStart()
	 *
	 * @param string $start
	 * @return $this
	 */
	public function setStart($start) {
		$this->start = (string) $start;
		return $this;
	}
	
	/**
	 * getStart()
	 *
	 * @return string
	 */
	public function getStart() {
		return $this->start;
	}
	
	/**
	 * setEnd()
	 *
	 * @param string $end
	 * @return $this
	 */
	public function setEnd($end) {
		$this->end = (string) $end;
		return $this;
	}
	
	/**
	 * getEnd()
	 *
	 * @return string
	 */
	public function getEnd() {
		return $this->end;
	}
	
	/**
	 * setCssClass()
	 *
	 * @param string $class
	 * @return $this
	 */
	public function setCssClass($class) {
		$this->cssClass = (string) $class;
		return $this;
	}
	
	/**
	 * getCssClass()
	 *
	 * @return string
	 */
	public function getCssClass() {
		return $this->cssClass;
	}
}
