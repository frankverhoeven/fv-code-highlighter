<?php

/**
 *	Functions.php
 *
 *	Functions to hook the plugin in Wordpress
 *
 *	@author		Frank Verhoeven
 */


/**
 *		fvch_htmlspecialchars_decode()
 *
 *		@param string $code
 *		@return string
 */
function fvch_htmlspecialchars_decode($code) {
	$converted = false;
	
	$checks = array(
		'&amp;amp;',
		'&lt;?php',
		'&lt;/'
	);
	
	foreach ($checks as $check) {
		if (strstr($code, $check)) {
			$converted = true;
		}
	}
	
	if ($converted) {
		return htmlspecialchars_decode($code);
	} else {
		return $code;
	}
}
