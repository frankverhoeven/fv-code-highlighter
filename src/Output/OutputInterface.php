<?php

namespace FvCodeHighlighter\Output;

/**
 * OutputInterface
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
interface OutputInterface
{
    /**
     * @param array $arguments
     * @return string|void
     */
    public function __invoke(...$arguments);
}
