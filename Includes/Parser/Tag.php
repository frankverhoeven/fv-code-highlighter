<?php

/**
 *	Tag.php
 *	Parser_Tag
 *
 *	Code Tag Parser
 *
 *	@author		Frank Verhoeven
 *	@version	1.0
 */

namespace FvCodeHighlighter;


class Parser_Tag extends Parser {
	
	/**
	 *		parse()
	 *
	 *		@param string $tag
	 *		@param string $cssClass
	 *		@return object $this
	 */
	public function parse($tag, $cssClass) {
		$this->setCode( str_replace($tag, '<span class="' . $cssClass . ' tag">' . $tag . '</span>', $this->getCode()) );
		
		return $this;
	}
	
}
