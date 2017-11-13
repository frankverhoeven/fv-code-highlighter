<?php

namespace FvCodeHighlighter\Parser;

/**
 * Key
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Key
{
    /**
     * @var string|array
     */
    protected $start;
    /**
     * @var bool
     */
    protected $includeStart;
    /**
     * @var string|array
     */
    protected $end;
    /**
     * @var bool
     */
    protected $includeEnd;
    /**
     * @var string
     */
    protected $startPre;
    /**
     * @var string
     */
    protected $startSuf;
    /**
     * @var string
     */
    protected $endPre;
    /**
     * @var string
     */
    protected $endSuf;
    /**
     * @var string
     */
    protected $css;
    /**
     * @var array
     */
    protected $sub;
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param array $options
     */
    public function __construct(array $options = null)
    {
		$this->setIncludeStart(true);
		$this->setIncludeEnd(true);
		
		if (null !== $options) {
			$this->setOptions($options);
		}
	}

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
		$methods = get_class_methods($this);
		$keys = array_keys($options);
		
		foreach ($keys as $name) {
			$method = 'set' . ucfirst($name);
			
			if (in_array($method, $methods)) {
				$this->$method($options[$name]);
			}
		}
	}

    /**
     * @param $start
     */
    public function setStart($start)
    {
		$this->start = $start;
	}

    /**
     * @return array|string
     */
    public function getStart()
    {
		return $this->start;
	}

    /**
     * @param $includeStart
     */
    public function setIncludeStart($includeStart)
    {
		$this->includeStart = $includeStart;
	}

    /**
     * @return bool
     */
    public function getIncludeStart()
    {
		return $this->includeStart;
	}

    /**
     * @param $end
     */
    public function setEnd($end)
    {
		$this->end = $end;
	}

    /**
     * @return array|string
     */
    public function getEnd()
    {
		return $this->end;
	}

    /**
     * @param $includeEnd
     */
    public function setIncludeEnd($includeEnd)
    {
		$this->includeEnd = $includeEnd;
	}

    /**
     * @return bool
     */
    public function getIncludeEnd()
    {
		return $this->includeEnd;
	}

    /**
     * @param $startPre
     */
    public function setStartPre($startPre)
    {
		$this->startPre = $startPre;
	}

    /**
     * @return string
     */
    public function getStartPre()
    {
		return $this->startPre;
	}

    /**
     * @param $startStartSuf
     */
    public function setStartSuf($startStartSuf)
    {
		$this->startSuf = $startStartSuf;
	}

    /**
     * @return string
     */
    public function getStartSuf()
    {
		return $this->startSuf;
	}

    /**
     * @param $endPre
     */
    public function setEndPre($endPre)
    {
		$this->endPre = $endPre;
	}

    /**
     * @return string
     */
    public function getEndPre()
    {
		return $this->endPre;
	}

    /**
     * @param $endEndSuf
     */
    public function setEndSuf($endEndSuf)
    {
		$this->endSuf = $endEndSuf;
	}

    /**
     * @return string
     */
    public function getEndSuf()
    {
		return $this->endSuf;
	}

    /**
     * @param $css
     */
    public function setCss($css)
    {
		$this->css = $css;
	}

    /**
     * @return string
     */
    public function getCss()
    {
		return $this->css;
	}

    /**
     * @param $sub
     */
    public function setSub($sub)
    {
		$this->sub = $sub;
	}

    /**
     * @return array
     */
    public function getSub()
    {
		return $this->sub;
	}

    /**
     * @param $callback
     */
    public function setCallback($callback)
    {
		$this->callback = $callback;
	}

    /**
     * @return callable
     */
    public function getCallback()
    {
		return $this->callback;
	}


    /**
     * @return bool
     */
    public function hasMultipleStarts()
    {
		return is_array($this->getStart());
	}

    /**
     * @return bool
     */
    public function hasEnd()
    {
		return (bool) $this->getEnd();
	}

    /**
     * @return bool
     */
    public function hasMultipleEnds()
    {
		return is_array($this->getEnd());
	}

    /**
     * @return bool
     */
    public function includeEnd()
    {
		return $this->getIncludeEnd();
	}

    /**
     * @return bool
     */
    public function includeStart()
    {
		return $this->getIncludeStart();
	}

    /**
     * @return bool
     */
    public function hasSub()
    {
		return (bool) $this->getSub();
	}

    /**
     * @return bool
     */
    public function hasCallback()
    {
		return (bool) $this->getCallback();
	}

    /**
     * @return bool
     */
    public function hasStartPre()
    {
		return (bool) $this->getStartPre();
	}

    /**
     * @return bool
     */
    public function hasStartSuf()
    {
		return (bool) $this->getStartSuf();
	}

    /**
     * @return bool
     */
    public function hasEndPre()
    {
		return (bool) $this->getEndPre();
	}

    /**
     * @return bool
     */
    public function hasEndSuf()
    {
		return (bool) $this->getEndSuf();
	}
}
