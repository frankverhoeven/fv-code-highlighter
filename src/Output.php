<?php

namespace FvCodeHighlighter;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Filter\HtmlSpecialCharsDecode;
use FvCodeHighlighter\Highlighter\AbstractHighlighter;
use FvCodeHighlighter\Highlighter\General\General;

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
     * @var Container
     */
    private $container;

    /**
     * __construct()
     *
     * @param Options $options
     * @param Cache $cache
     * @param Container $container
     * @version 20171118
     */
    public function __construct(Options $options, Cache $cache, Container $container)
    {
        $this->options = $options;
        $this->cache = $cache;
        $this->container = $container;
    }

    /**
     * Find code blocks and highlight them.
     *
     * @param string $content
     * @return string
     * @version 20171118
     * @throws \Exception
     */
    public function highlightCode($content)
    {
        if (!strstr($content, '{code') && !strstr($content, '[code')) {
            return $content;
        }

        $defaultSettings = [
            'type' => ''
        ];

        $patterns = [
            '/^(?!<code>)\{code(?<arguments>.*?)\}(?<code>.*?)\{\/code\}/msi',
            '/^(?!<code>)\[code(?<arguments>.*?)\](?<code>.*?)\[\/code\]/msi',
        ];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $codes);
            $num = count($codes[0]);

            for ($i = 0; $i < $num; $i++) {
                $settings = wp_parse_args($codes['arguments'][$i], $defaultSettings);

                $classname = ucfirst(strtolower($settings['type']));
                if ('Php' == $classname) {
                    $classname = 'Html'; // @todo: hack, fix
                }
                $class = 'FvCodeHighlighter\\Highlighter\\' . $classname . '\\' . $classname;

                $filter = new HtmlSpecialCharsDecode();
                $code = trim($filter->filter($codes['code'][$i]));

                $cacheFile = sha1($code . $settings['type']);
                if ($this->cache->cacheFileExists($cacheFile)) {
                    $code = $this->cache->getCacheFile($cacheFile);
                } else {
                    if (class_exists($class)) {
                        /* @var $highlighter AbstractHighlighter */
                        $highlighter = $this->container->get($class);
                        $code = $highlighter->highlight($code);

                        $this->cache->createCacheFile($cacheFile, $code);
                    } else {
                        $highlighter = $this->container->get(General::class);
                        $code = $highlighter->highlight($code);

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
                        foreach (array_reverse($openTags) as $tag) {
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
            for ($i = 0; $i < $openTags; $i++) {
                $tags[] = $i = strpos($openLine, '<span class="', $offset);
                $offset = $i + 1;
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
     * @param string $line
     * @return string
     * @version 20171113
     */
    protected function stripClosedTags($line)
    {
        while (false != preg_match('/\<span class\="(?<class>[a-z-]+)"\>(?<code>((?!\<span|\<\/span).)*)\<\/span\>/', $line, $matches)) {
            $line = str_replace($matches[0], '', $line);
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

        $fontSize = esc_attr($this->options->getOption('fvch-font-size')) . 'em';
        ?>
        <style type="text/css">
            .fvch-codeblock {
                background: <?php echo $background; ?> !important;
                background-position-y: 4px !important;
            }

            .fvch-codeblock pre, .fvch-line-number {
                line-height: <?php echo 'notepaper' == $this->options->getOption('fvch-background') ? '17px' : '1.4em'; ?> !important;
                font-family: <?php echo $font; ?> !important;
                font-size: <?php echo $fontSize; ?> !important;
            }
        </style>
        <meta name="generator" content="FV Code Highlighter">
        <?php
    }

    /**
     * Include the colors stylesheet in the footer to make it non-blocking.
     *
     * @return void
     */
    public function displayFooter()
    {
        $stylesheet = plugins_url('public/css/fvch-styles.min.css', dirname(__FILE__));
        if (file_exists(get_stylesheet_directory() . '/fvch-styles.min.css')) {
            $stylesheet = get_stylesheet_directory_uri() . '/fvch-styles.min.css';
        }

        ?>
        <script type="text/javascript">
            (function(){
                var stylesheet = document.createElement('link');
                stylesheet.rel = 'stylesheet';
                stylesheet.href = '<?= $stylesheet; ?>';
                stylesheet.type = 'text/css';
                stylesheet.media = 'screen';
                document.getElementsByTagName('head')[0].appendChild(stylesheet);
            })();
        </script>
        <?php
    }
}
