<?php

namespace FvCodeHighlighter\Parser;

/**
 * Tag
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Tag extends Parser
{
	/**
	 * parse()
	 *
	 * @param string $tag
	 * @param string $cssClass
	 * @return $this
	 */
	public function parse($tag, $cssClass)
    {
		$this->setCode(str_replace($tag, '<span class="' . $cssClass . ' tag">' . $tag . '</span>', $this->getCode()));
		return $this;
	}
}
