<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Parser;

final class Output
{
    /** @var string */
    private $output;

    public function __construct(string $output = '')
    {
        $this->output = $output;
    }

    public function add(string $code, string $cssClass = null)
    {
        if ($cssClass !== null) {
            $this->addBlockStart($cssClass);
            $this->output .= \htmlspecialchars($code);
            $this->addBlockEnd();
        }

        $this->output .= \htmlspecialchars($code);
    }

    public function addBlockStart(string $cssClass)
    {
        $this->output .= '<span class="' . $cssClass . '">';
    }

    public function addBlockEnd()
    {
        $this->output .= '</span>';
    }

    public function __toString(): string
    {
        return $this->output;
    }
}
