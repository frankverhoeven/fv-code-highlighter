<?php

/**
 * FvCodeHighlighter_Parser
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Parser
{
	/**
	 * Code
	 * @var string
	 */
	protected $_code = null;

	/**
	 * Parsed Code
	 * @var string
	 */
	protected $_parsedCode = '';

	/**
	 * Pointer
	 * @var int
	 */
	protected $_pointer = 0;

	/**
	 * Keys
	 * @var array
	 */
	protected $_keys = array();

	/**
	 * Current open key
	 * @var int
	 */
	protected $_currentKey = 0;

	/**
	 * Curernt start
	 * @var string
	 */
	protected $_currentStart = '';

	/**
	 * Current end
	 * @var string
	 */
	protected $_currentEnd = '';

    /**
     * Tab size in spaces.
     * @var int
     */
    protected $_tabSize = 4;

	/**
	 * Constructor.
	 *
	 * @param string $code
     * @return void
	 */
	public function __construct($code)
    {
		$this->setCode($code);
	}

	/**
	 * setCode()
	 *
	 * @param string $code
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setCode($code)
    {
		$this->_code = (string) $code;
		return $this;
	}

	/**
	 * getCode()
	 *
	 * @return string
	 */
	public function getCode()
    {
		return $this->_code;
	}

	/**
	 * Set parsed code.
	 *
	 * @param string $code
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setParsedCode($code)
    {
		$this->_parsedCode = (string) $code;
		return $this;
	}

	/**
	 * Get parsed code.
	 *
	 * @return string
	 */
	public function getParsedCode()
    {
		return $this->_parsedCode;
	}

	/**
	 * Add parsed code.
	 *
	 * @param string $code
	 * @return \FvCodeHighlighter_Parser
	 */
	public function addParsedCode($code)
    {
        $this->_parsedCode .= (string) $code;
		return $this;
	}

	/**
	 * setPointer()
	 *
	 * @param int $pointer
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setPointer($pointer)
    {
		$this->_pointer = (int) $pointer;
		return $this;
	}

	/**
	 * getPointer()
	 *
	 * @return int
	 */
	public function getPointer()
    {
		return $this->_pointer;
	}

	/**
	 * increasePointer()
	 *
	 * @param int $increment (optional)
	 * @return \FvCodeHighlighter_Parser
	 */
	public function increasePointer($increment=1)
    {
        $this->_pointer += (int) $increment;
		return $this;
	}

	/**
	 * setKeys()
	 *
	 * @param array $keys
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setKeys($keys)
    {
		$this->_keys = $keys;
		return $this;
	}

	/**
	 * getKeys()
	 *
	 * @return array
	 */
	public function getKeys()
    {
		return $this->_keys;
	}

	/**
	 * getKey()
	 *
	 * @param int $key
	 * @return array
	 */
	public function getKey($key)
    {
		return $this->_keys[ $key ];
	}

	/**
	 * addKey()
	 *
	 * @param array $key
	 * @return \FvCodeHighlighter_Parser
	 */
	public function addKey($key)
    {
		$this->_keys[] = $key;
		return $this;
	}

	/**
	 * setCurrentKey()
	 *
	 * @param object $key
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setCurrentKey($key)
    {
		$this->_currentKey = $this->_keys[ $key ];
		return $this;
	}

	/**
	 * getCurrentKey()
	 *
	 * @return int
	 */
	public function getCurrentKey()
    {
		return $this->_currentKey;
	}

	/**
	 * setCurrentStart()
	 *
	 * @param string $start
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setCurrentStart($start)
    {
		$this->_currentStart = (string) $start;
		return $this;
	}

	/**
	 * getCurrentStart()
	 *
	 * @return string
	 */
	public function getCurrentStart()
    {
		return $this->_currentStart;
	}

	/**
	 * setCurrentEnd()
	 *
	 * @param string $end
	 * @return \FvCodeHighlighter_Parser
	 */
	public function setCurrentEnd($end)
    {
		$this->_currentEnd = (string) $end;
		return $this;
	}

	/**
	 * getCurrentEnd()
	 *
	 * @return string
	 */
	public function getCurrentEnd()
    {
		return $this->_currentEnd;
	}

    /**
     * Get tab size in spaces.
     *
     * @return int
     */
    public function getTabSize()
    {
        return $this->_tabSize;
    }

    /**
     * Set tab size in spaces.
     *
     * @param int $tabSize
     * @return \FvCodeHighlighter_Parser
     */
    public function setTabSize($tabSize)
    {
        $this->_tabSize = abs( (int) $tabSize );
        return $this;
    }

    /**
     * Prepare the code for parsing.
     *
     * @return \FvCodeHighlighter_Parser
     */
    protected function _prepareCode()
    {
        $code = str_replace("\r", "\n", str_replace("\r\n", "\n", $this->getCode()));
        $this->setCode($code);

        return $this;
    }

    /**
     * Convert tabs to spaces.
     *
     * @return \FvCodeHighlighter_Parser
     */
    protected function _convertTabsToSpaces()
    {
        $tabSize = $this->getTabSize();
        $code = $this->getCode();
        $lines = explode("\n", $code);

        foreach ($lines as $line)
        {
            while (false !== $tabPos = strpos($line, "\t"))
            {
                $start = substr($line, 0, $tabPos);
                $tab = str_repeat(' ', $tabSize - $tabPos % $tabSize);
                $end = substr($line, $tabPos + 1);
                $line = $start . $tab . $end;
            }

            $result[] = $line;
        }

        $this->setCode( implode("\n", $result) );

        return $this;
    }

	/**
	 * Parse the code.
	 *
	 * @return \FvCodeHighlighter_Parser
	 */
	public function parse()
    {
		$this->setPointer(0);
		$code = $this->_prepareCode()->_convertTabsToSpaces()->getCode();
        $codeLength = mb_strlen($code);

		while ($this->getPointer() < $codeLength) {
			$subCode = mb_substr($code, $this->getPointer());

			if ($this->_findStart($subCode)) {
				if ($this->getCurrentKey()->includeStart()) {
					$parsed = '<span class="' . $this->getCurrentKey()->getCss() . '">';
					$parsed .= htmlspecialchars($this->getCurrentStart());
				} else {
					$parsed = htmlspecialchars($this->getCurrentStart());
					$parsed .= '<span class="' . $this->getCurrentKey()->getCss() . '">';
				}

				$this->increasePointer( mb_strlen($this->getCurrentStart()) );

				if ($this->getCurrentKey()->hasEnd()) {
					$subCode = mb_substr($code, $this->getPointer());
					$pointer = $this->getPointer();

					$end = true;
					while (!$this->_findEnd($subCode)) {
						$this->increasePointer();
						$subCode = mb_substr($code, $this->getPointer());

						if ($this->getPointer() > $codeLength) {
							$end = false;
							break;
						}
					}

					$subsubCode = mb_substr($code, $pointer, $this->getPointer() - $pointer);
					if ($this->getCurrentKey()->hasSub() || $this->getCurrentKey()->hasCallback()) {
						if ($this->getCurrentKey()->hasSub()) {
							if (!$this->getCurrentKey()->includeEnd()) {
								$parser = new FvCodeHighlighter_Parser($subsubCode . $this->getCurrentEnd());
								$subsubCode = mb_substr($parser->setKeys( $this->getCurrentKey()->getSub() )
													 ->parse()
													 ->getParsedCode(), 0, -1);
							} else {
								$parser = new FvCodeHighlighter_Parser($subsubCode);
								$subsubCode = $parser->setKeys( $this->getCurrentKey()->getSub() )
													 ->parse()
													 ->getParsedCode();
							}
						}
						if ($this->getCurrentKey()->hasCallback()) {
							$subsubCode = call_user_func($this->getCurrentKey()->getCallback(), $subsubCode);
						}

						$parsed .= $subsubCode;
					} else {
						$parsed .= htmlspecialchars($subsubCode);
					}

					if ($this->getCurrentKey()->includeEnd()) {
						if ($end) {
							$parsed .= htmlspecialchars($this->getCurrentEnd());
						}
						$this->increasePointer( mb_strlen($this->getCurrentEnd()) );
					}
				}

				$parsed .= '</span>';
				$this->addParsedCode( $parsed );
			} else {
				$this->addParsedCode( htmlspecialchars( mb_substr($code, $this->getPointer(), 1) ) );
				$this->increasePointer();
			}
		}

		return $this;
	}


	/**
	 * _findStart()
	 *
	 * @param string $code
	 * @return bool
	 */
	public function _findStart($code)
    {
		foreach ($this->getKeys() as $id=>$key) {
			$match = false;

			if (($key->hasStartPre() && $this->_checkStartPrefix($key)) || !$key->hasStartPre()) {
				if ($key->hasMultipleStarts()) {
					foreach ($key->getStart() as $start) {
						if ($start == mb_substr($code, 0, mb_strlen($start))) {
							if (($key->hasStartSuf() && $this->_checkStartSuffix($start, $key)) || !$key->hasStartSuf()) {
								$match = true;
								$this->setCurrentStart( $start );
							}
						}
					}
				} else {
					if ($key->getStart() == mb_substr($code, 0, mb_strlen($key->getStart()))) {
						if (($key->hasStartSuf() && $this->_checkStartSuffix($key->getStart(), $key)) || !$key->hasStartSuf()) {
							$match = true;
							$this->setCurrentStart( $key->getStart() );
						}
					}
				}
			}

			if ($match) {
				$this->setCurrentKey( $id );

				return true;
			}
		}

		return false;
	}

	/**
	 * _findEnd()
	 *
	 * @param string $code
	 * @return bool
	 */
	protected function _findEnd($code)
    {
		$match = false;

		if (($this->getCurrentKey()->hasEndPre() && $this->_checkEndPrefix()) || !$this->getCurrentKey()->hasEndPre()) {
			if ($this->getCurrentKey()->hasMultipleEnds()) {
				foreach ($this->getCurrentKey()->getEnd() as $end) {
					if ($end == mb_substr($code, 0, mb_strlen($end))) {
						if (($this->getCurrentKey()->hasEndSuf() && $this->_checkEndSuffix($end)) || !$this->getCurrentKey()->hasEndSuf()) {
							$match = true;
							$this->setCurrentEnd( $end );
						}
					}
				}
			} else {
				if ('@match' == $this->getCurrentKey()->getEnd()) {
					$end = $this->getCurrentStart();
				} else {
					$end = $this->getCurrentKey()->getEnd();
				}

				if ($end == mb_substr($code, 0, mb_strlen($end))) {
					if (($this->getCurrentKey()->hasEndSuf() && $this->_checkEndSuffix($end)) || !$this->getCurrentKey()->hasEndSuf()) {
						$match = true;
						$this->setCurrentEnd( $end );
					}
				}
			}
		}

		return $match;
	}

	/**
	 * _checkStartPrefix()
	 *
	 * @return bool
	 */
	protected function _checkStartPrefix($key)
    {
		$prefix = mb_substr($this->getCode(), $this->getPointer()-1, 1);

		if (preg_match('/' . $key->getStartPre() . '/', $prefix)) {
			return true;
		}

		return false;
	}

	/**
	 * _checkStartSuffix()
	 *
	 * @return bool
	 */
	protected function _checkStartSuffix($start, $key)
    {
		$suffix = mb_substr($this->getCode(), $this->getPointer() + mb_strlen($start), 1);

		if (preg_match('/' . $key->getStartSuf() . '/', $suffix)) {
			return true;
		}

		return false;
	}

	/**
	 * _checkEndPrefix()
	 *
	 * @return bool
	 */
	protected function _checkEndPrefix()
    {
		$prefix = mb_substr($this->getCode(), $this->getPointer()-1, 1);

		if (preg_match('/' . $this->getCurrentKey()->getEndPre() . '/', $prefix)) {
			return true;
		}

		return false;
	}

	/**
	 * _checkEndSuffix()
	 *
	 * @return bool
	 */
	protected function _checkEndSuffix($end)
    {
		$suffix = mb_substr($this->getCode(), $this->getPointer() + mb_strlen($end), 1);

		if (preg_match('/' . $this->getCurrentKey()->getEndSuf() . '/', $suffix)) {
			return true;
		}

		return false;
	}
}
