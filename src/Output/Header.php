<?php

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter\Config;

/**
 * Header
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Header implements OutputInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $arguments
     * @return void
     */
    public function __invoke(...$arguments)
    {
        $background = [
            'notepaper' => 'url(' . \plugins_url('public/images/notepaper.png', \dirname(__FILE__)) . ') top left repeat',
            'white' => '#fff',
            'custom' => \esc_attr($this->config['fvch-background-custom'])
        ];
        $background = $background[$this->config['fvch-background']];

        $font = [
            'Andale Mono' => "'Andale Mono', 'Courier New', Courier, monospace",
            'Courier' => "Courier, 'Courier New', Courier, monospace",
            'Courier New' => "'Courier New', Courier, monospace",
            'Menlo' => "'Menlo', 'Courier New', Courier, monospace",
            'Monaco' => "'Monaco', 'Courier New', Courier, monospace"
        ];
        $font = $font[$this->config['fvch-font-family']];

        $fontSize = \esc_attr($this->config['fvch-font-size']) . 'em';
        ?>
        <style type="text/css">
            .fvch-codeblock {
                background: <?= $background; ?> !important;
                background-position-y: 4px !important;
            }
            .fvch-codeblock pre, .fvch-line-number {
                line-height: <?= 'notepaper' == $this->config['fvch-background'] ? '17px' : '1.4em'; ?> !important;
                font-family: <?= $font; ?> !important;
                font-size: <?= $fontSize; ?> !important;
            }
        </style>
        <meta name="generator" content="FV Code Highlighter">
        <?php
    }
}
