<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output;

interface Output
{
    /**
     * @return string|void
     */
    public function __invoke();
}
