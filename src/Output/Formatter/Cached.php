<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output\Formatter;

use FvCodeHighlighter\Cache\Cache;
use FvCodeHighlighter\Cache\HashGenerator;

final class Cached implements Formatter
{
    /** @var Cache */
    private $cache;

    /** @var HashGenerator */
    private $hashGenerator;

    /** @var Formatter */
    private $innerHighlighter;

    public function __construct(
        Cache $cache,
        HashGenerator $hashGenerator,
        Formatter $innerHighlighter
    ) {
        $this->cache            = $cache;
        $this->hashGenerator    = $hashGenerator;
        $this->innerHighlighter = $innerHighlighter;
    }

    /**
     * @param mixed[] $options
     */
    public function format(string $code, Options $options): string
    {
        $hash = $this->hashGenerator->generate([$code, $options->language()]);

        if ($this->cache->has($hash)) {
            return $this->cache->get($hash);
        }

        $this->cache->set(
            $hash,
            $code = $this->innerHighlighter->format($code, $options)
        );

        return $code;
    }
}
