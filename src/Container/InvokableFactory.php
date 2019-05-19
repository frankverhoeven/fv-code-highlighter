<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

final class InvokableFactory implements Factory
{
    /**
     * phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
     *
     * @return object
     */
    public function __invoke(Container $container, string $requestedName)
    {
        return new $requestedName();
    }
}
