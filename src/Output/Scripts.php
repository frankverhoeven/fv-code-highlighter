<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter;
use FvCodeHighlighter\Config;

final class Scripts implements Output
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __invoke()
    {
        $reflection = new \ReflectionClass(FvCodeHighlighter::class);
        $file       = $reflection->getFileName();

        if ($this->config['fvch-toolbox']) {
            \wp_enqueue_script(
                'fvch-toolbox',
                \plugins_url('public/js/toolbox.min.js', $file),
                ['jquery'],
                '1.1',
                true
            );
        }

        if ($this->config['fvch-dark-mode']) {
            $stylesheet = \plugins_url('public/css/fvch-styles-dark.min.css', $file);
        } else {
            $stylesheet = \plugins_url('public/css/fvch-styles.min.css', $file);
        }

        if (\file_exists(\get_stylesheet_directory() . '/fvch-styles.min.css')) {
            $stylesheet = \get_stylesheet_directory_uri() . '/fvch-styles.min.css';
        }

        \wp_register_style('fvch-styles', $stylesheet, false, '1.2');
        \wp_enqueue_style('fvch-styles');
    }
}
