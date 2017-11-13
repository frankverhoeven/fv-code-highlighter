<?php

namespace FvCodeHighlighter;

use FvCodeHighlighter\Filter\HtmlSpecialCharsDecode;
use FvCodeHighlighter\Highlighter\AbstractHighlighter;
use FvCodeHighlighter\Highlighter\General;

/**
 * Output
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Output
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * __construct()
     *
     * @param Options $options
     * @param Cache $cache
     * @version 20171107
     */
    public function __construct(Options $options, Cache $cache)
    {
        $this->options = $options;
        $this->cache = $cache;
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

        $defaultSettings = [
            'type' => ''
        ];

        preg_match_all('/\[code(?<arguments>.*?)\](?<code>.*?)\[\/code\]/msi', $content, $codes);
        $num = count($codes[0]);

        for ($i=0; $i<$num; $i++) {
            $settings = wp_parse_args($codes['arguments'][ $i ], $defaultSettings);
            $class = 'FvCodeHighlighter\\Highlighter\\' . ucfirst(strtolower($settings['type']));
            $filter = new HtmlSpecialCharsDecode();
            $code = $filter->filter(trim($codes['code'][ $i ]));

            $cacheFile = sha1($code . $settings['type']);
            if ($this->cache->cacheFileExists($cacheFile)) {
                $code = $this->cache->getCacheFile($cacheFile);
            } else {
                if (class_exists($class)) {
                    /* @var $highlighter AbstractHighlighter */
                    $highlighter = new $class($code);
                    $code = $highlighter->highlight()
                                        ->getCode();

                    unset($highlighter);
                    $this->cache->createCacheFile($cacheFile, $code);
                } else {
                    $highlighter = new General($code);
                    $code = $highlighter->highlight()
                        ->getCode();

                    unset($highlighter);
                    $this->cache->createCacheFile($cacheFile, $code);
                }
            }

            $output = '<div class="fvch-codeblock">';

            if ($this->options->getOption('fvch-toolbox')) {
                $output .= '<div class="fvch-hide-if-no-js fvch-toolbox">';

                $output .= '<img src="' . plugins_url('public/images/copy-icon.svg', dirname(__FILE__))
                        . '" alt="' . __('Select Code', 'fvch') . '" title="' . __('Select Code', 'fvch')
                        . '" class="fvch-toolbox-icon fvch-toolbox-icon-select" />';

                $output .= '</div>';
            }

            $output .= '<table class="fvch-code ' . strtolower($settings['type']) . '">';

            $lineNumber = 1;
            $openTags = null;
            $lines = explode("\n", $code);
            foreach ($lines as $line) {
                $output .= '<tr>';

                if ($this->options->getOption('fvch-line-numbers')) {
                    $output .= '<td class="fvch-line-number" data-line-number="' . $lineNumber . '"></td>';
                }

                if (null !== $openTags) {
                    foreach ($openTags as $tag) {
                        $line = '<span class="' . $tag . '">' . $line;
                    }
                }

                $closedLine = force_balance_tags($line);
                $openTags = $this->getOpenTagClasses($line, $closedLine);
                // wrap in pre tags to prevent wptexturize
                $output .= '<td class="fvch-line-code"><pre>' . $closedLine . '</pre></td>';

                $output .= '</tr>';
                $lineNumber++;
            }

            $output .= '</table></div><!--fvch-codeblock-->';

            $content = str_replace($codes[0][$i], $output, $content);
        }

        return $content;
    }

    /**
     * Get unclosed tags from $openLine
     *
     * @param string $openLine
     * @param string $closedLine
     * @return array|null
     */
    protected function getOpenTagClasses($openLine, $closedLine)
    {
        $openTags = (strlen($closedLine) - strlen($openLine)) / 7;
        $openLine = $this->stripClosedTags($openLine);

        if ($openTags > 0) {
            $tags = [];
            $offset = 0;
            for (; $openTags > 0; $openTags--) {
                $tags[] = $i = strrpos($openLine, '<span class="', $offset);
                $offset = -1 * (strlen($openLine) - $i);
            }
            foreach ($tags as $i => $tag) {
                $startClass = $tags[$i] + 13;
                $tags[$i] = substr($openLine, $startClass, strpos($openLine, '"', $startClass) - $startClass);
            }

            return $tags;
        }

        return null;
    }

    /**
     * Strip closed tags from $line
     *
     * Assumes more open-tags than close-tags
     *
     * @param string $line
     * @return string
     * @version 20171113
     */
    protected function stripClosedTags($line)
    {
        $closeOffset = 0;
        while (false !== ($closeTag = strrpos($line, '</span>', $closeOffset))) {
            $closeOffset = -1 * (strlen($line) - $closeTag);
            $openTag = strrpos($line, '<span class="', $closeOffset);
            $line = str_replace(substr($line, $openTag, ($closeTag - $openTag) + 7), '', $line);
            $closeOffset = 0;
        }

        return $line;
    }

    /**
     * Enqueue scripts and stylesheets.
     *
     * @return void
     */
    public function enqueueScripts()
    {
        $stylesheet = plugins_url('public/css/fvch-styles.min.css', dirname(__FILE__));
        if (file_exists(get_stylesheet_directory() . '/fvch-styles.css')) {
            $stylesheet = get_stylesheet_directory_uri() . '/fvch-styles.css';
        }

        wp_register_style('fvch-styles', $stylesheet, false, '1.2');
        wp_enqueue_style('fvch-styles');

        if ($this->options->getOption('fvch-toolbox')) {
            wp_enqueue_script('fvch-toolbox', plugins_url('public/js/toolbox.min.js', dirname(__FILE__)), ['jquery'], '1.1', true);
        }
    }

    /**
     * Display stuff in the head section.
     *
     * @return void
     */
    public function displayHead()
    {
        $background = [
            'notepaper' => 'url(' . plugins_url('public/images/notepaper.png', dirname(__FILE__)) . ') top left repeat',
            'white' => '#fff',
            'custom' => esc_attr($this->options->getOption('fvch-background-custom'))
        ];
        $background = $background[$this->options->getOption('fvch-background')];

        $font = [
            'Andale Mono' => "'Andale Mono', 'Courier New', Courier, monospace",
            'Courier' => "Courier, 'Courier New', Courier, monospace",
            'Courier New' => "'Courier New', Courier, monospace",
            'Menlo' => "'Menlo', 'Courier New', Courier, monospace",
            'Monaco' => "'Monaco', 'Courier New', Courier, monospace"
        ];
        $font = $font[$this->options->getOption('fvch-font-family')];

        $fontSize = esc_attr($this->options->getOption('fvch-font-size')) . 'px';
        ?>
        <style type="text/css">
            .fvch-codeblock {
                background: <?php echo $background; ?>;
            }

            .fvch-codeblock pre, .fvch-line-number {
                line-height: <?php echo 'notepaper' == $this->options->getOption('fvch-background') ? '17px' : '1.4em'; ?>;
                font-family: <?php echo $font; ?>;
                font-size: <?php echo $fontSize; ?>;
            }
        </style>
        <meta name="generator" content="FV Code Highlighter">
        <?php
    }
}
