<?php

namespace FvCodeHighlighter\Output;

use FvCodeHighlighter;
use FvCodeHighlighter\Options;

/**
 * Scripts
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Scripts implements OutputInterface
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
        $reflection = new \ReflectionClass(FvCodeHighlighter::class);
        $file = $reflection->getFileName();

        if ($this->options->getOption('fvch-toolbox')) {
            wp_enqueue_script(
                'fvch-toolbox',
                plugins_url('public/js/toolbox.min.js', $file),
                ['jquery'],
                '1.1',
                true
            );
        }

        $stylesheet = plugins_url('public/css/fvch-styles.min.css', $file);
        if (file_exists(get_stylesheet_directory() . '/fvch-styles.min.css')) {
            $stylesheet = get_stylesheet_directory_uri() . '/fvch-styles.min.css';
        }

        wp_register_style('fvch-styles', $stylesheet, false, '1.2');
        wp_enqueue_style('fvch-styles');
    }
}
