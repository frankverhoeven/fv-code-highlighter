<?php

/**
 * FvCodeHighlighter_Bootstrap_Abstract
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
abstract class FvCodeHighlighter_Bootstrap_Abstract
{
	/**
	 * Run all bootstrap methods.
	 *
	 * @return \FvCodeHighlighter_Bootstrap_Abstract
	 */
	public function bootstrap()
	{
		$methods = get_class_methods($this);

		foreach ($methods as $method) {
			if (0 === strpos($method, '_init')) {
				$this->$method();
			}
		}

		return $this;
	}
}

