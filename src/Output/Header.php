<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter\Config;

final class Header implements Output
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __invoke()
    {
        $background = [
            'notepaper' => 'url(' . \plugins_url('public/images/notepaper.png', __DIR__) . ') top left repeat',
            'white' => '#fff',
            'custom' => \esc_attr($this->config['fvch-background-custom']),
        ];
        $background = $background[$this->config['fvch-background']];

        if ($this->config['fvch-dark-mode']) {
            $background = '#2e2e2d';
        }

        $font = [
            'Andale Mono' => "'Andale Mono', 'Courier New', Courier, monospace",
            'Courier'     => "Courier, 'Courier New', Courier, monospace",
            'Courier New' => "'Courier New', Courier, monospace",
            'Menlo'       => "'Menlo', 'Courier New', Courier, monospace",
            'Monaco'      => "'Monaco', 'Courier New', Courier, monospace",
        ];

        \printf(
            '<style type="text/css">
            .fvch-codeblock {
                background: %s !important;
                background-position-y: 4px !important;
            }
            .fvch-codeblock pre, .fvch-line-number {
                line-height: %s !important;
                font-family: %s !important;
                font-size: %s !important;
            }
        </style>
        <meta name="generator" content="FV Code Highlighter - https://frankverhoeven.me/">',
            $background,
            $this->config['fvch-background'] === 'notepaper' ? '17px' : '1.5em',
            $font[$this->config['fvch-font-family']],
            \esc_attr($this->config['fvch-font-size']) . 'em'
        );
    }
}
