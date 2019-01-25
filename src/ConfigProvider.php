<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter\Container\Geshi\GeshiFactory;
use FvCodeHighlighter\Geshi\GeSHi;

final class ConfigProvider
{
    /**
     * @return mixed[]
     */
    public function __invoke(): array
    {
        return [
            'services' => $this->services(),
            'defaults' => $this->defaults(),
        ];
    }

    /**
     * @return string[]
     */
    private function services(): array
    {
        return [
            GeSHi::class => GeshiFactory::class,
        ];
    }

    /**
     * @return mixed[]
     */
    private function defaults(): array
    {
        return [
            /**
             * @var string Current plugin version.
             */
            'fvch_version' => Version::getCurrentVersion(),

            /**
             * @var string Cache directory.
             */
            'fvch-cache-dir' => \dirname(__DIR__) . '/cache',

            /**
             * @var string CSS font-family.
             */
            'fvch-font-family' => 'Monaco',

            /**
             * @var string CSS font-size (em)
             */
            'fvch-font-size' => '0.8',

            /**
             * @var string Background (notepaper, white, custom)
             */
            'fvch-background' => 'white',

            /**
             * @var string Custom CSS background-color.
             */
            'fvch-background-custom' => '#ffffff',

            /**
             * @var bool Whether to use line numbers.
             */
            'fvch-line-numbers' => true,

            /**
             * @var bool Whether to use the toolbox.
             */
            'fvch-toolbox' => false,

            /**
             * @var bool Whether to use dark mode.
             */
            'fvch-dark-mode' => true,

            /**
             * @var bool Whether to enable diagnostics.
             */
            'fvch-diagnostics' => true,
        ];
    }
}
