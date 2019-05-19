<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container\Factory\Output\Formatter;

use FvCodeHighlighter\Cache\Cache;
use FvCodeHighlighter\Cache\HashGenerator;
use FvCodeHighlighter\Config;
use FvCodeHighlighter\Container\Container;
use FvCodeHighlighter\Container\Factory;
use FvCodeHighlighter\Diagnostics\Code;
use FvCodeHighlighter\Filter\CleanBeforeParse;
use FvCodeHighlighter\Highlighter\Provider;
use FvCodeHighlighter\Output\Formatter\Cached;
use FvCodeHighlighter\Output\Formatter\Diagnoser;
use FvCodeHighlighter\Output\Formatter\Filtered;
use FvCodeHighlighter\Output\Formatter\Formatter;
use FvCodeHighlighter\Output\Formatter\HtmlTable;
use FvCodeHighlighter\Output\Formatter\LineNumbers;
use FvCodeHighlighter\Output\Formatter\Parser;
use FvCodeHighlighter\Output\Formatter\Toolbox;

final class FormatterFactory implements Factory
{
    public function __invoke(Container $container, string $requestedName): Formatter
    {
        $config = $container->get(Config::class);

        // @todo implement proper decoration
        return new Toolbox(
            $config,
            new LineNumbers(
                $config,
                new Cached(
                    $container->get(Cache::class),
                    $container->get(HashGenerator::class),
                    new HtmlTable(
                        new Filtered(
                            $container->get(CleanBeforeParse::class),
                            new Diagnoser(
                                $container->get(Code::class),
                                $config,
                                new Parser(
                                    $container->get(Provider::class)
                                )
                            )
                        )
                    )
                )
            )
        );
    }
}
