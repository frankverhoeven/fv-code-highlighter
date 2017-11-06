<?php

namespace FvCodeHighlighter\Parser;

/**
 * Parser
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Parser
{
	/**
	 * Code
	 * @var string
	 */
	protected $code = null;

	/**
	 * Parsed Code
	 * @var string
	 */
	protected $parsedCode = '';

	/**
	 * Pointer
	 * @var int
	 */
	protected $pointer = 0;

	/**
	 * Keys
	 * @var Key[]
	 */
	protected $keys = [];

	/**
	 * Current open key
	 * @var Key
	 */
	protected $currentKey = null;

	/**
	 * Curernt start
	 * @var string
	 */
	protected $currentStart = '';

	/**
	 * Current end
	 * @var string
	 */
	protected $currentEnd = '';

    /**
     * Tab size in spaces.
     * @var int
     */
    protected $tabSize = 4;

	/**
	 * Constructor.
	 *
	 * @param string $code
	 */
	public function __construct($code)
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
	 * Set parsed code.
	 *
	 * @param string $code
	 * @return $this
	 */
	public function setParsedCode($code)
    {
		$this->parsedCode = (string) $code;
		return $this;
	}

	/**
	 * Get parsed code.
	 *
	 * @return string
	 */
	public function getParsedCode()
    {
		return $this->parsedCode;
	}

	/**
	 * Add parsed code.
	 *
	 * @param string $code
	 * @return $this
	 */
	public function addParsedCode($code)
    {
        $this->parsedCode .= (string) $code;
		return $this;
	}

	/**
	 * setPointer()
	 *
	 * @param int $pointer
	 * @return $this
	 */
	public function setPointer($pointer)
    {
		$this->pointer = (int) $pointer;
		return $this;
	}

	/**
	 * getPointer()
	 *
	 * @return int
	 */
	public function getPointer()
    {
		return $this->pointer;
	}

	/**
	 * increasePointer()
	 *
	 * @param int $increment (optional)
	 * @return $this
	 */
	public function increasePointer($increment=1)
    {
        $this->pointer += (int) $increment;
		return $this;
	}

	/**
	 * setKeys()
	 *
	 * @param Key[] $keys
	 * @return $this
	 */
	public function setKeys($keys)
    {
		$this->keys = $keys;
		return $this;
	}

	/**
	 * getKeys()
	 *
	 * @return Key[]
	 */
	public function getKeys()
    {
		return $this->keys;
	}

	/**
	 * getKey()
	 *
	 * @param int $key
	 * @return Key
	 */
	public function getKey($key)
    {
		return $this->keys[ $key ];
	}

	/**
	 * addKey()
	 *
	 * @param Key $key
	 * @return $this
	 */
	public function addKey(Key $key)
    {
		$this->keys[] = $key;
		return $this;
	}

	/**
	 * setCurrentKey()
	 *
	 * @param int $key
	 * @return $this
	 */
	public function setCurrentKey($key)
    {
		$this->currentKey = $this->keys[ $key ];
		return $this;
	}

	/**
	 * getCurrentKey()
	 *
	 * @return Key
	 */
	public function getCurrentKey()
    {
		return $this->currentKey;
	}

	/**
	 * setCurrentStart()
	 *
	 * @param string $start
	 * @return $this
	 */
	public function setCurrentStart($start)
    {
		$this->currentStart = (string) $start;
		return $this;
	}

	/**
	 * getCurrentStart()
	 *
	 * @return string
	 */
	public function getCurrentStart()
    {
		return $this->currentStart;
	}

	/**
	 * setCurrentEnd()
	 *
	 * @param string $end
	 * @return $this
	 */
	public function setCurrentEnd($end)
    {
		$this->currentEnd = (string) $end;
		return $this;
	}

	/**
	 * getCurrentEnd()
	 *
	 * @return string
	 */
	public function getCurrentEnd()
    {
		return $this->currentEnd;
	}

    /**
     * Get tab size in spaces.
     *
     * @return int
     */
    public function getTabSize()
    {
        return $this->tabSize;
    }

    /**
     * Set tab size in spaces.
     *
     * @param int $tabSize
     * @return $this
     */
    public function setTabSize($tabSize)
    {
        $this->tabSize = abs((int) $tabSize);
        return $this;
    }

    /**
     * Prepare the code for parsing.
     *
     * @return $this
     */
    protected function prepareCode()
    {
        $code = str_replace("\r", "\n", str_replace("\r\n", "\n", $this->getCode()));
        $this->setCode($code);

        return $this;
    }

    /**
     * Convert tabs to spaces.
     *
     * @return $this
     */
    protected function convertTabsToSpaces()
    {
        $result = [];
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

        $this->setCode(implode("\n", $result));

        return $this;
    }

	/**
	 * Parse the code.
	 *
	 * @return $this
	 */
	public function parse()
    {
		$this->setPointer(0);
		$code = $this->prepareCode()->convertTabsToSpaces()->getCode();
        $codeLength = mb_strlen($code);

		while ($this->getPointer() < $codeLength) {
			$subCode = mb_substr($code, $this->getPointer());

			if ($this->findStart($subCode)) {
				if ($this->getCurrentKey()->includeStart()) {
					$parsed = '<span class="' . $this->getCurrentKey()->getCss() . '">';
					$parsed .= htmlspecialchars($this->getCurrentStart());
				} else {
					$parsed = htmlspecialchars($this->getCurrentStart());
					$parsed .= '<span class="' . $this->getCurrentKey()->getCss() . '">';
				}

				$this->increasePointer(mb_strlen($this->getCurrentStart()));

				if ($this->getCurrentKey()->hasEnd()) {
					$subCode = mb_substr($code, $this->getPointer());
					$pointer = $this->getPointer();

					$end = true;
					while (!$this->findEnd($subCode)) {
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
								$parser = new Parser($subsubCode . $this->getCurrentEnd());
								$subsubCode = mb_substr($parser->setKeys($this->getCurrentKey()->getSub())
													 ->parse()
													 ->getParsedCode(), 0, -1);
							} else {
								$parser = new Parser($subsubCode);
								$subsubCode = $parser->setKeys($this->getCurrentKey()->getSub())
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
						$this->increasePointer(mb_strlen($this->getCurrentEnd()));
					}
				}

				$parsed .= '</span>';
				$this->addParsedCode($parsed);
			} else {
				$this->addParsedCode(htmlspecialchars(mb_substr($code, $this->getPointer(), 1)));
				$this->increasePointer();
			}
		}

		return $this;
	}

	/**
	 * findStart()
	 *
	 * @param string $code
	 * @return bool
	 */
	public function findStart($code)
    {
		foreach ($this->getKeys() as $id=>$key) {
			$match = false;

			if (($key->hasStartPre() && $this->checkStartPrefix($key)) || !$key->hasStartPre()) {
				if ($key->hasMultipleStarts()) {
					foreach ($key->getStart() as $start) {
						if ($start == mb_substr($code, 0, mb_strlen($start))) {
							if (($key->hasStartSuf() && $this->checkStartSuffix($start, $key)) || !$key->hasStartSuf()) {
								$match = true;
								$this->setCurrentStart($start);
							}
						}
					}
				} else {
					if ($key->getStart() == mb_substr($code, 0, mb_strlen($key->getStart()))) {
						if (($key->hasStartSuf() && $this->checkStartSuffix($key->getStart(), $key)) || !$key->hasStartSuf()) {
							$match = true;
							$this->setCurrentStart($key->getStart());
						}
					}
				}
			}

			if ($match) {
				$this->setCurrentKey($id);

				return true;
			}
		}

		return false;
	}

	/**
	 * findEnd()
	 *
	 * @param string $code
	 * @return bool
	 */
	protected function findEnd($code)
    {
		$match = false;

		if (($this->getCurrentKey()->hasEndPre() && $this->checkEndPrefix()) || !$this->getCurrentKey()->hasEndPre()) {
			if ($this->getCurrentKey()->hasMultipleEnds()) {
				foreach ($this->getCurrentKey()->getEnd() as $end) {
					if ($end == mb_substr($code, 0, mb_strlen($end))) {
						if (($this->getCurrentKey()->hasEndSuf() && $this->checkEndSuffix($end)) || !$this->getCurrentKey()->hasEndSuf()) {
							$match = true;
							$this->setCurrentEnd($end);
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
					if (($this->getCurrentKey()->hasEndSuf() && $this->checkEndSuffix($end)) || !$this->getCurrentKey()->hasEndSuf()) {
						$match = true;
						$this->setCurrentEnd($end);
					}
				}
			}
		}

		return $match;
	}

    /**
     * checkStartPrefix()
     *
     * @param Key $key
     * @return bool
     */
	protected function checkStartPrefix(Key $key)
    {
		$prefix = mb_substr($this->getCode(), $this->getPointer()-1, 1);

		if (preg_match('/' . $key->getStartPre() . '/', $prefix)) {
			return true;
		}

		return false;
	}

    /**
     * checkStartSuffix()
     *
     * @param string $start
     * @param Key $key
     * @return bool
     */
	protected function checkStartSuffix($start, Key $key)
    {
		$suffix = mb_substr($this->getCode(), $this->getPointer() + mb_strlen($start), 1);

		if (preg_match('/' . $key->getStartSuf() . '/', $suffix)) {
			return true;
		}

		return false;
	}

	/**
	 * checkEndPrefix()
	 *
	 * @return bool
	 */
	protected function checkEndPrefix()
    {
		$prefix = mb_substr($this->getCode(), $this->getPointer()-1, 1);

		if (preg_match('/' . $this->getCurrentKey()->getEndPre() . '/', $prefix)) {
			return true;
		}

		return false;
	}

    /**
     * checkEndSuffix()
     *
     * @param string $end
     * @return bool
     */
	protected function checkEndSuffix($end)
    {
		$suffix = mb_substr($this->getCode(), $this->getPointer() + mb_strlen($end), 1);

		if (preg_match('/' . $this->getCurrentKey()->getEndSuf() . '/', $suffix)) {
			return true;
		}

		return false;
	}
}
