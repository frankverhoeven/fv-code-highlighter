<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter\Cache;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Diagnostics\Code;
use FvCodeHighlighter\Diagnostics\Error;
use FvCodeHighlighter\Filter\Chain;
use FvCodeHighlighter\Filter\HtmlSpecialCharsDecode;
use FvCodeHighlighter\Filter\Trim;
use FvCodeHighlighter\Highlighter\AbstractHighlighter;
use FvCodeHighlighter\Highlighter\General\General;

final class Highlighter implements Output
{
    /** @var Config */
    protected $config;

    /** @var Cache */
    private $cache;

    /** @var Container */
    private $container;

    public function __construct(Config $config, Cache $cache, Container $container)
    {
        $this->config    = $config;
        $this->cache     = $cache;
        $this->container = $container;
    }

    public function __invoke() : string
    {
//        try {
            return $this->highlightCode(\func_get_arg(0));
//        } catch (\Throwable $exception) {
//            Error::diagnose($exception);
//        }

//        return \func_get_arg(0);
    }

    /**
     * Find code blocks and highlight them.
     */
    public function highlightCode(string $content) : string
    {
        if (! \strstr($content, '{code') && ! \strstr($content, '[code') && ! \strstr($content, '<pre')) {
            return $content;
        }

        $defaultSettings = ['type' => ''];

        $patterns = [
            '/\<pre(?<arguments>.*?)\>(?<code>.*?)\<\/pre\>/msi',
            '/\{code(?<arguments>.*?)\}(?<code>.*?)\{\/code\}/msi',
            '/\[code(?<arguments>.*?)\](?<code>.*?)\[\/code\]/msi',
        ];

        foreach ($patterns as $pattern) {
            \preg_match_all($pattern, $content, $codes);
            $num = \count($codes[0]);

            for ($i = 0; $i < $num; $i++) {
                $settings = \wp_parse_args($codes['arguments'][$i], $defaultSettings);

                if ((! isset($settings['type']) || $settings['type'] === '') && isset($settings['lang'])) {
                    $settings['type'] = $settings['lang'];
                }
                $settings['type'] = \trim($settings['type'], '"\'');

                $classname = \ucfirst(\strtolower($settings['type']));
                if ($classname === 'Php') {
                    //$classname = 'Html'; // @todo: hack, fix
                }
                $class = 'FvCodeHighlighter\\Highlighter\\' . $classname . '\\' . $classname;

                $filter = new Chain([new HtmlSpecialCharsDecode(), new Trim()]);
                $code   = $filter->filter($codes['code'][$i]);

                if ($this->config['fvch-diagnostics']) {
                    Code::diagnose($code, $settings['type']);
                }

                $cacheFile = $this->cache->generateHash($code, $settings['type']);
                if ($this->cache->cacheFileExists($cacheFile)) {
                    $code = $this->cache->getCacheFile($cacheFile);
                } else {
                    if (\class_exists($class)) {
                        /** @var AbstractHighlighter $highlighter */
                        $highlighter = $this->container->get($class);
                        $code        = $highlighter->highlight($code);

                        $this->cache->createCacheFile($cacheFile, $code);
                    } else {
                        $highlighter = $this->container->get(General::class);
                        $code        = $highlighter->highlight($code);

                        $this->cache->createCacheFile($cacheFile, $code);
                    }
                }

                $output = '<div class="fvch-codeblock">';

                if ($this->config['fvch-toolbox']) {
                    $output .= '<div class="fvch-hide-if-no-js fvch-toolbox">';
                    $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fvch-toolbox-icon fvch-toolbox-icon-select"><path d="M433.941 65.941l-51.882-51.882A48 48 0 0 0 348.118 0H176c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h224c26.51 0 48-21.49 48-48v-48h80c26.51 0 48-21.49 48-48V99.882a48 48 0 0 0-14.059-33.941zM266 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h74v224c0 26.51 21.49 48 48 48h96v42a6 6 0 0 1-6 6zm128-96H182a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h106v88c0 13.255 10.745 24 24 24h88v202a6 6 0 0 1-6 6zm6-256h-64V48h9.632c1.591 0 3.117.632 4.243 1.757l48.368 48.368a6 6 0 0 1 1.757 4.243V112z"></path></svg>';
                    $output .= '</div>';
                }

                $output .= '<table class="fvch-code ' . \strtolower($settings['type']) . '">';

                $lineNumber = 1;
                $openTags   = null;
                $lines      = \explode("\n", $code);
                foreach ($lines as $line) {
                    $output .= '<tr>';

                    if ($this->config['fvch-line-numbers']) {
                        $output .= '<td class="fvch-line-number" data-line-number="' . $lineNumber . '"></td>';
                    }

                    if ($openTags !== null) {
                        foreach (\array_reverse($openTags) as $tag) {
                            $line = '<span class="' . $tag . '">' . $line;
                        }
                    }

                    $closedLine = \force_balance_tags($line);
                    $openTags   = $this->getOpenTagClasses($line, $closedLine);
                    // wrap in pre tags to prevent wptexturize
                    $output .= '<td class="fvch-line-code"><pre>' . $closedLine . '</pre></td>';

                    $output .= '</tr>';
                    $lineNumber++;
                }

                $output .= '</table></div>';

                $content = \str_replace($codes[0][$i], $output, $content);
            }
        }

        return $content;
    }

    /**
     * Get unclosed tags from $openLine
     *
     * @return int[]|null
     */
    protected function getOpenTagClasses(string $openLine, string $closedLine)
    {
        $openTags = (\strlen($closedLine) - \strlen($openLine)) / 7;
        $openLine = $this->stripClosedTags($openLine);

        if ($openTags > 0) {
            $tags   = [];
            $offset = 0;
            for ($i = 0; $i < $openTags; $i++) {
                $tags[] = $i = \strpos($openLine, '<span class="', $offset);
                $offset = $i + 1;
            }
            foreach ($tags as $i => $tag) {
                $startClass = $tags[$i] + 13;
                $tags[$i]   = \substr($openLine, $startClass, \strpos($openLine, '"', $startClass) - $startClass);
            }

            return $tags;
        }

        return null;
    }

    /**
     * Strip closed tags from $line
     */
    protected function stripClosedTags(string $line) : string
    {
        while (\preg_match('/\<span class\="(?<class>[a-z-]+)"\>(?<code>((?!\<span|\<\/span).)*)\<\/span\>/', $line, $matches) === 1) {
            $line = \str_replace($matches[0], '', $line);
        }

        return $line;
    }
}
