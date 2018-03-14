<?php

namespace FvCodeHighlighter\Highlighter;

/**
 * HighlighterInterface
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
interface HighlighterInterface
{
    /**
     * Setup highlighter elements
     *
     */
    public function setup();

    /**
     * Code pre processing
     *
     * @param string $code
     * @return string
     */
    public function preProcess(string $code): string;

    /**
     * Code post processing
     *
     * @param string $code
     * @return string
     */
    public function postProcess(string $code): string;

    /**
     * Highliht the provided code
     *
     * @param string $code
     * @return string
     */
    public function highlight(string $code): string;
}
