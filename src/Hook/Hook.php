<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Hook;

interface Hook
{
    /**
     * @param mixed ...$arguments
     *
     * @return mixed|void
     */
    public function __invoke(...$arguments);
}
