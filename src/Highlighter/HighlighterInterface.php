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
     * Code post processing
     *
     * @param string $code
     * @return string
     */
    public function postProcess($code);

    /**
     * Highliht the provided code
     *
     * @param string $code
     * @return string
     */
    public function highlight($code);
}
