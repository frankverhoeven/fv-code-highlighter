<?php

/**
 * FvCodeHighlighter_Container
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Container extends FvCodeHighlighter_Container_Abstract
{
	/**
	 * Get options object.
	 *
	 * @return FvCodeHighlighter_Options
	 */
	public function getOptions()
	{
		if (isset($this->_objects['options'])) {
			return $this->_objects['options'];
		}

		return $this->_objects['options'] = new FvCodeHighlighter_Options();
	}

	/**
	 * Get cacher.
	 *
	 * @return FvCodeHighlighter_Cache
	 */
	public function getCache()
	{
		if (isset($this->_objects['cache'])) {
			return $this->_objects['cache'];
		}

		return $this->_objects['cache'] = new FvCodeHighlighter_Cache(
			$this->getOptions()->getOption('fvch-cache-dir')
		);
	}
}
