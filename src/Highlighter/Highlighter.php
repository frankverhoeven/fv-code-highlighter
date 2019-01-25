<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter;

interface Highlighter
{
    /**
     * Setup highlighter elements
     */
    public function setup();

    /**
     * Code pre processing
     */
    public function preProcess(string $code): string;

    /**
     * Code post processing
     */
    public function postProcess(string $code): string;

    /**
     * Highliht the provided code
     */
    public function highlight(string $code): string;
}
