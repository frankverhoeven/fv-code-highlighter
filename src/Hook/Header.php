<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Hook;

use FvCodeHighlighter\Config;

final class Header implements Hook
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param mixed ...$arguments
     *
     * @return void
     */
    public function __invoke(...$arguments)
    {
        $background = [
            'notepaper' => 'url(' . \plugins_url('public/images/notepaper.png', __DIR__) . ') top left repeat',
            'white' => '#fff',
            'custom' => \esc_attr($this->config->get('fvch-background-custom')),
        ];
        $background = $background[$this->config->get('fvch-background', 'white')];

        if ($this->config->get('fvch-dark-mode')) {
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
            $this->config->get('fvch-background') === 'notepaper' ? '17px' : '1.5em',
            $font[$this->config->get('fvch-font-family', 'Monaco')],
            \esc_attr($this->config->get('fvch-font-size', '0.8')) . 'em'
        );
    }
}
