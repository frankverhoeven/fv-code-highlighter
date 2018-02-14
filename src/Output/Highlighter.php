<?php

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter;
use FvCodeHighlighter\Cache;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Filter\HtmlSpecialCharsDecode;
use FvCodeHighlighter\Highlighter\AbstractHighlighter;
use FvCodeHighlighter\Highlighter\General\General;
use FvCodeHighlighter\Options;

/**
 * Highlighter
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Highlighter implements OutputInterface
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
     */
    public function __construct(Options $options, Cache $cache, Container $container)
    {
        $this->options = $options;
        $this->cache = $cache;
        $this->container = $container;
    }

    /**
     * @param array $arguments
     * @return string
     */
    public function __invoke(...$arguments)
    {
        $content = array_shift($arguments);
        return $this->highlightCode($content);
    }

    /**
     * Find code blocks and highlight them.
     *
     * @param string $content
     * @return string
     */
    public function highlightCode($content)
    {
        if (!strstr($content, '{code') && !strstr($content, '[code') && !strstr($content, '<pre')) {
            return $content;
        }

        $defaultSettings = [
            'type' => ''
        ];

        $patterns = [
            '/\<pre(?<arguments>.*?)\>(?<code>.*?)\<\/pre\>/msi',
            '/\{code(?<arguments>.*?)\}(?<code>.*?)\{\/code\}/msi',
            '/\[code(?<arguments>.*?)\](?<code>.*?)\[\/code\]/msi',
        ];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $codes);
            $num = count($codes[0]);

            for ($i = 0; $i < $num; $i++) {
                $settings = wp_parse_args($codes['arguments'][$i], $defaultSettings);

                if ((!isset($settings['type']) || '' == $settings['type']) && isset($settings['lang'])) {
                    $settings['type'] = $settings['lang'];
                }
                $settings['type'] = trim($settings['type'], '"\'');

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

                    $reflection = new \ReflectionClass(FvCodeHighlighter::class);
                    $file = $reflection->getFileName();

                    $output .= '<img src="' . plugins_url('public/images/copy-icon.svg', $file)
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
     */
    protected function stripClosedTags($line)
    {
        while (false != preg_match('/\<span class\="(?<class>[a-z-]+)"\>(?<code>((?!\<span|\<\/span).)*)\<\/span\>/', $line, $matches)) {
            $line = str_replace($matches[0], '', $line);
        }

        return $line;
    }
}
