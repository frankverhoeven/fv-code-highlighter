<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Filter;

final class TabsToSpaces implements Filter
{
    /** @var int */
    private $tabSize = 4;

    public function filter(string $value) : string
    {
        $lines = \explode("\n", $value);

        foreach ($lines as $n => $line) {
            while (($tabPos = \strpos($line, "\t")) !== false) {
                $start = \substr($line, 0, $tabPos);
                $tab   = \str_repeat(' ', $this->tabSize - $tabPos % $this->tabSize);
                $end   = \substr($line, $tabPos + 1);
                $line  = $start . $tab . $end;
            }

            $lines[$n] = $line;
        }

        return \implode("\n", $lines);
    }

    public function tabSize(int $tabSize)
    {
        $this->tabSize = $tabSize;
    }
}
