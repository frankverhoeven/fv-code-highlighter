<?php

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter\Options;

/**
 * Header
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Header implements OutputInterface
{
    /**
     * @var Options
     */
    private $options;

    /**
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @param array $arguments
     * @return string|void
     */
    public function __invoke(...$arguments)
    {
        $background = [
            'notepaper' => 'url(' . plugins_url('public/images/notepaper.png', dirname(__FILE__)) . ') top left repeat',
            'white' => '#fff',
            'custom' => esc_attr($this->options->getOption('fvch-background-custom'))
        ];
        $background = $background[$this->options->getOption('fvch-background')];

        $font = [
            'Andale Mono' => "'Andale Mono', 'Courier New', Courier, monospace",
            'Courier' => "Courier, 'Courier New', Courier, monospace",
            'Courier New' => "'Courier New', Courier, monospace",
            'Menlo' => "'Menlo', 'Courier New', Courier, monospace",
            'Monaco' => "'Monaco', 'Courier New', Courier, monospace"
        ];
        $font = $font[$this->options->getOption('fvch-font-family')];

        $fontSize = esc_attr($this->options->getOption('fvch-font-size')) . 'em';
        ?>
        <style type="text/css">
            .fvch-codeblock {
                background: <?= $background; ?> !important;
                background-position-y: 4px !important;
            }
            .fvch-codeblock pre, .fvch-line-number {
                line-height: <?= 'notepaper' == $this->options->getOption('fvch-background') ? '17px' : '1.4em'; ?> !important;
                font-family: <?= $font; ?> !important;
                font-size: <?= $fontSize; ?> !important;
            }
        </style>
        <meta name="generator" content="FV Code Highlighter">
        <?php
    }
}
