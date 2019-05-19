<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Container;

final class AliasedFactory implements Factory
{
    /** @var string */
    private $alias;

    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return mixed
     */
    public function __invoke(Container $container, string $requestedName)
    {
        return $container->get($this->alias);
    }
}
