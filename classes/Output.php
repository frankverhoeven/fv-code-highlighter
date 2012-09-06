<?php

/**
 * FvCodeHighlighter_Output
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Output
{
    /**
     * Options Handler
     * @var FvCodeHighlighter_Options
     */
    protected $_options;

    /**
     * Constructor.
     *
     * @param FvCodeHighlighter_Options $options
     * @return void
     */
    public function __construct(FvCodeHighlighter_Options $options)
    {
        $this->_options = $options;
    }

    /**
     * Find code blocks and highlight them.
     *
     * @param string $content
     * @return string
     */
    public function highlightCode($content)
    {
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
                $filter = new FvCodeHighlighter_Filter_HtmlSpecialCharsDecode();
                $code = $filter->filter( trim($codes['code'][ $i ]));

                $cacheFile = sha1($code);
                $cache = FvCodeHighlighter_Container::getInstance()->getCache();

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

                $output = '<div id="fvch-codeblock-' . $i . '" class="fvch-codeblock">';

                if ($this->_options->getOption('fvch-toolbox')) {
                    $output .= '<div class="fvch-hide-if-no-js fvch-toolbox">';

                    $output .= '<img src="' . plugins_url('public/images/select-icon.png', dirname(__FILE__))
                            . '" alt="' . __('Select Code', 'fvch') . '" title="' . __('Select Code', 'fvch')
                            . '" class="fvch-toolbox-icon fvch-toolbox-icon-select" />';

                    $output .= '</div>';
                }

                $output .= '<table><tr>';

                if ($this->_options->getOption('fvch-line-numbers')) {
                    $count = count( explode("\n", $code) );

                    $numbers = '';
                    for ($n=1; $n<=$count; $n++) {
                        $numbers .= $n . "\n";
                    }

                    $output .= '<td class="fvch-line-numbers"><pre>' . $numbers . '</pre></td>';
                }

                $output .= '<td class="fvch-code"><pre id="fvch-code-' . $i . '">' . $code . '</pre></td>';
                $output .= '</tr></table></div>';

                $content = str_replace($codes[0][$i], $output, $content);
            }
        }

        return $content;
    }

    /**
     * Enqueue scripts and stylesheets.
     *
     * @return void
     */
    public function enqueueScripts()
    {
        $stylesheet = plugins_url('public/css/fvch-styles.css', dirname(__FILE__));
        if (file_exists( get_stylesheet_directory() . '/fvch-styles.css' )) {
            $stylesheet = get_stylesheet_directory_uri() . '/fvch-styles.css';
        }

        wp_register_style('fvch-styles', $stylesheet, false, '1.1');
        wp_enqueue_style('fvch-styles' );

        if ($this->_options->getOption('fvch-toolbox')) {
            wp_enqueue_script('fvch-toolbox', plugins_url('public/js/toolbox.js', dirname(__FILE__)), array('jquery'), '1.0', true);
        }
    }

    /**
     * Display stuff in the head section.
     *
     * @return void
     */
    public function displayHead()
    {
        $background = array(
            'notepaper'	=> 'url(' . plugins_url('public/images/notepaper.png', dirname(__FILE__)) . ') top left repeat',
            'white'		=> '#fff',
            'custom'    => esc_attr( $this->_options->getOption('fvch-background-custom') )
        );
        $background = $background[ $this->_options->getOption('fvch-background') ];

        $font = array(
            'Andale Mono'	=> "'Andale Mono', Courier New', Courier, monospace",
            'Courier'		=> "Courier, 'Courier New', Courier, monospace",
            'Courier New'	=> "'Courier New', Courier, monospace",
            'Menlo'			=> "'Menlo', 'Courier New', Courier, monospace",
            'Monaco'		=> "'Monaco', 'Courier New', Courier, monospace"
        );
        $font = $font[ $this->_options->getOption('fvch-font-family') ];

        $fontSize = esc_attr( $this->_options->getOption('fvch-font-size') ) . 'px';
        ?>
        <style type="text/css">
            .fvch-codeblock {
                background: <?php echo $background; ?>;
            }
            .fvch-codeblock pre, .fvch-line-numbers pre {
                background: <?php echo $background; ?>;
                line-height: <?php echo 'notepaper' == $this->_options->getOption('fvch-background') ? '18px' : '1.3em'; ?>;
                font-family: <?php echo $font; ?>;
                font-size: <?php echo $fontSize; ?>;
            }
            .fvch-line-numbers pre {
                background: #e2e2e2;
            }
        </style>
        <meta name="generator" content="FV Code Highlighter" />
        <?php
    }
}
