<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

final class HtmlTable implements Formatter
{
    /** @var Formatter */
    private $innerHighlighter;

    public function __construct(Formatter $innerHighlighter)
    {
        $this->innerHighlighter = $innerHighlighter;
    }

    public function format(string $code, Options $options): string
    {
        $code   = $this->innerHighlighter->format($code, $options);
        $output = '<div class="fvch-codeblock"><table class="fvch-code ' . $options->language() . '">';

        $openTags = null;
        $lines    = \explode("\n", $code);
        foreach ($lines as $line) {
            $output .= '<tr>';

            if ($openTags !== null) {
                $line = '<span class="' . \implode('"><span class="', \array_reverse($openTags)) . '">' . $line;
            }

            $closedLine = \force_balance_tags($line);
            $openTags   = $this->getOpenTagClasses($line, $closedLine);
            $output    .= '<td class="fvch-line-code"><pre>' . $closedLine . '<br></pre></td>';

            $output .= '</tr>';
        }

        $output .= '</table></div>';

        return $output;
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
    protected function stripClosedTags(string $line): string
    {
        while (\preg_match(
            '/\<span class\="(?<class>[a-z-]+)"\>(?<code>((?!\<span|\<\/span).)*)\<\/span\>/',
            $line,
            $matches
        ) === 1) {
            $line = \str_replace($matches[0], '', $line);
        }

        return $line;
    }
}
