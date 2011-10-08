<?php

/**
 *	Hooks.php
 *	
 *	WordPress Hooks
 *
 *	@author		Frank Verhoeven
 */


/**
 *		install()
 *
 *		@return void
 */
function fvch_install() {
	$install = new FvCodeHighlighter_Install(FvCodeHighlighter_Version::VERSION);
	
	if (FvCodeHighlighter_Version::compareInstalled('1.1')) {
		$install->deleteDeprecated();
	}
	if (FvCodeHighlighter_Version::compareCurrent(FvCodeHighlighter_Version::getLatest())) {
		// TODO: Not latest
	}
	
	$install->installSettings();
	
	$cache = new FvCodeHighlighter_Cache(get_option('fvch-cache-dir'));
	$cache->clear();
}

/**
 *		content()
 *
 *		@param string $content
 *		@return string
 */
function fvch_content($content) {
	if (!strstr($content, '{code') && !strstr($content, '[code')) {
		return $content;
	}
	
	$patterns = array(
		'/\{code(?<arguments>.*?)\}(?<code>.*?)\{\/code\}/msi',
		'/\[code(?<arguments>.*?)\](?<code>.*?)\[\/code\]/msi'
	);
	$defaultSettings = array(
		'type'	=> ''
	);
	
	foreach ($patterns as $pattern) {
		preg_match_all($pattern, $content, $codes);
		$num = count($codes[0]);
		
		for ($i=0; $i<$num; $i++) {
			$settings = wp_parse_args($codes['arguments'][ $i ], $defaultSettings);
			$class = 'FvCodeHighlighter_Highlighter_' . ucfirst( strtolower($settings['type']) );
			$code = trim( fvch_htmlspecialchars_decode($codes['code'][ $i ]) );
			$plain = htmlspecialchars( $code );
			
			$cacheFile = sha1($code);
			$cache = new FvCodeHighlighter_Cache(get_option('fvch-cache-dir'));
			
			if ($cache->cacheFileExists($cacheFile)) {
				$code = $cache->getCacheFile($cacheFile);
			} else {
				if (class_exists($class)) {
					$highlighter = new $class( $code );
					
					$code = $highlighter->highlight()
										->getCode();
					
					unset($highlighter);
					$cache->createCacheFile($cacheFile, $code);
				} else {
					$code = esc_html( $code );
				}
			}
			
			if (get_option('fvch-line-numbers')) {
				$count = count( explode("\n", str_replace(array("\n\r", "\r"), "\n", $code)) );
				
				$numbers = '';
				for ($n=1; $n<=$count; $n++) {
					$numbers .= $n . "\n";
				}
				
				$code = '<div class="fvch-code"><pre class="fvch-line-numbers">' . $numbers . '</pre><pre>' . $code . '</pre></div>';
			} else {
				$code = '<div class="fvch-code"><pre>' . $code . '</pre></div>';
			}
			
			$content = str_replace($codes[0][$i], $code, $content);
		}
	}
	
	return $content;
}
add_filter('the_content', 'fvch_content', 3);
add_filter('comment_text', 'fvch_content', 3);

/**
 *		fvch_enqueue_scripts()
 *
 *		@return void
 */
function fvch_enqueue_scripts() {
	
}
add_action('wp_enqueue_scripts', 'fvch_enqueue_scripts');

/**
 *		wp_head()
 *
 *		@return void
 */
function fvch_wp_head() {
	$background = array(
		'notepaper'	=> 'url(' . WP_PLUGIN_URL . '/fv-code-highlighter/public/images/notepaper.png) top left repeat',
		'white'		=> '#fff'
	);
	$background = $background[ get_option('fvch-background') ];
	
	$font = array(
		'Andale Mono'	=> "'Andale Mono', Courier New', Courier, monospace",
		'Courier'		=> "Courier, 'Courier New', Courier, monospace",
		'Courier New'	=> "'Courier New', Courier, monospace",
		'Menlo'			=> "'Menlo', 'Courier New', Courier, monospace",
		'Monaco'		=> "'Monaco', 'Courier New', Courier, monospace"
	);
	$font = $font[ get_option('fvch-font-family') ];
	
	$fontSize = get_option('fvch-font-size') . 'px';
	?>
	<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/fv-code-highlighter/public/css/highlighter.css" media="all" />
	<style type="text/css">
		<?php if (get_option('fvch-line-numbers')) : ?>.fvch-code pre {
			margin-left: 3.1em !important;
			padding: 1px 0 1px 10px !important;
		}<?php endif; ?> 
		.fvch-code pre, pre.fvch-line-numbers {
			background: <?php echo $background; ?>;
			<?php if ('notepaper' == get_option('fvch-background')) echo 'line-height: 18px;'; else echo 'line-height: 1.3em;' ?> 
			font-family: <?php echo $font; ?>;
			font-size: <?php echo $fontSize; ?>;
		}
		pre.fvch-line-numbers {
			background: #e2e2e2;
			margin: 0 !important;
			padding: 1px 4px 1px 0 !important;
		}
	</style>
	<meta name="generator" content="FV Code Highlighter" />
	<?php
}
add_action('wp_head', 'fvch_wp_head');

/**
 *		admin_menu()
 *
 *		@return void
 */
function fvch_admin_menu() {
	if (function_exists('add_submenu_page')) {
		add_theme_page(
			__('FV Code Highlighter Control', 'fvch'),
			__('Code Highlighter', 'fvch'),
			'edit_themes',
			'fv-code-highlighter-control',
			'fvch_admin_page'
		);
	}
}
add_action('admin_menu', 'fvch_admin_menu');

/**
 *		admin_page()
 *
 *		@return void
 */
function fvch_admin_page() {
	require_once FVCH_ROOT . '/Includes/Admin.php';
}

/**
 *		admin_head()
 *
 *		@return void
 */
function fvch_admin_head() {
	echo '<link rel="stylesheet" href="' . WP_PLUGIN_URL . '/fv-code-highlighter/public/css/admin.css" media="all" />' . PHP_EOL;
}
add_action('admin_head', 'fvch_admin_head');
