<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Geshi;

use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Geshi\GeSHi;

final class GeshiFactory implements Factory
{
    /**
     * @return mixed
     */
    public function __invoke(Container $container, string $requestedName): GeSHi
    {
        $geshi = new GeSHi();
        $geshi->enable_classes(true);
        $geshi->enable_keyword_links(false);

        return $geshi;
    }
}
