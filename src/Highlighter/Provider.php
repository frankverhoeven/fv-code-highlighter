<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter;

use FvCodeHighlighter\Container\Container;

final class Provider
{
    /** @var Container */
    private $container;

    /** @var LanguageMap */
    private $languageMap;

    public function __construct(Container $container, LanguageMap $languageMap)
    {
        $this->container   = $container;
        $this->languageMap = $languageMap;
    }

    public function getHighlighter(string $language): Highlighter
    {
        return $this->container->get(
            $this->languageMap->highlighterClassForLanguage($language)
        );
    }
}
