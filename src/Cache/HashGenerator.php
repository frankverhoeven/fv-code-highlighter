<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Cache;

final class HashGenerator
{
    /**
     * @param string[] $keys
     */
    public function generate(array $keys): string
    {
        return \sha1(\implode('', $keys));
    }
}
