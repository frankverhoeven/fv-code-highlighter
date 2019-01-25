<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output;

interface OutputInterface
{
    /**
     * @param mixed[] $arguments
     *
     * @return string|void
     */
    public function __invoke(...$arguments);
}
