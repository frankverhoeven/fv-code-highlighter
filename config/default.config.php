<?php

use FvCodeHighlighter\Version;

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
    'fvch-font-size' => '1',

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
];
