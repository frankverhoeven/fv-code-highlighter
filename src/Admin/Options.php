<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Config;

// phpcs:disable Generic.Files.InlineHTML
// phpcs:disable Generic.Files.LineLength

final class Options
{
    /** @var Config */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->init();
    }

    public function init()
    {
        if (!\current_user_can('edit_themes')) {
            \wp_die(\__('You do not have sufficient permissions to manage options for this site.'));
        }

        // Font
        \add_settings_section(
            'fvch_setting_font_section',
            \__('Font', 'fvch'),
            [$this, 'fontSection'],
            'fvch-options'
        );

        \add_settings_field(
            'fvch-font-family',
            \__('Font Family', 'fvch'),
            [$this, 'fontFamily'],
            'fvch-options',
            'fvch_setting_font_section'
        );
        \register_setting(
            'fvch-options',
            'fvch-font-family',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        \add_settings_field(
            'fvch-font-size',
            \__('Font Size', 'fvch'),
            [$this, 'fontSize'],
            'fvch-options',
            'fvch_setting_font_section'
        );
        \register_setting(
            'fvch-options',
            'fvch-font-size',
            [
                'type'              => 'number',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        // Background
        \add_settings_section(
            'fvch_setting_background_section',
            \__('Background', 'fvch'),
            [$this, 'backgroundSection'],
            'fvch-options'
        );

        \add_settings_field(
            'fvch-background',
            \__('Background', 'fvch'),
            [$this, 'background'],
            'fvch-options',
            'fvch_setting_background_section'
        );
        \register_setting(
            'fvch-options',
            'fvch-background',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        \register_setting(
            'fvch-options',
            'fvch-background-custom',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        // Utilities
        \add_settings_section(
            'fvch_setting_utility_section',
            \__('Utilities', 'fvch'),
            [$this, 'utilitySection'],
            'fvch-options'
        );

        \add_settings_field(
            'fvch-line-numbers',
            \__('Line Numbers', 'fvch'),
            [$this, 'lineNumbers'],
            'fvch-options',
            'fvch_setting_utility_section'
        );
        \register_setting(
            'fvch-options',
            'fvch-line-numbers',
            [
                'type'              => 'boolean',
                'sanitize_callback' => 'boolval',
            ]
        );

        \add_settings_field(
            'fvch-toolbox',
            \__('Toolbox', 'fvch'),
            [$this, 'toolbox'],
            'fvch-options',
            'fvch_setting_utility_section'
        );
        \register_setting(
            'fvch-options',
            'fvch-toolbox',
            [
                'type'              => 'boolean',
                'sanitize_callback' => 'boolval',
            ]
        );

        \add_settings_field(
            'fvch-dark-mode',
            \__('Dark Mode', 'fvch'),
            [$this, 'darkMode'],
            'fvch-options',
            'fvch_setting_utility_section'
        );
        \register_setting('fvch-options', 'fvch-dark-mode', ['type' => 'boolean', 'sanitize_callback' => 'boolval']);
    }

    public function page()
    {
        ?>
        <div class="wrap">
            <h2><?php \_e('FV Code Highlighter Options', 'fvch') ?></h2>
            <?php \settings_errors() ?>

            <div class="fvch-support">
                <a href="https://www.paypal.me/FrankVerhoeven" class="button button-primary">
                    <?php \_e('Support this plugin', 'fvch') ?>
                </a>
            </div>

            <form action="<?= \admin_url('options.php') ?>" method="post">
                <?php \settings_fields('fvch-options') ?>
                <?php \do_settings_sections('fvch-options') ?>

                <?php \submit_button() ?>
            </form>
        </div>
        <?php
    }

    public function fontSection()
    {
    }

    public function fontFamily()
    {
        ?>
        <label>
            <input type="radio" name="fvch-font-family" value="Andale Mono" id="fvch-font-family_0" <?php \checked('Andale Mono', $this->config['fvch-font-family']) ?>>
            <span style="font-family: 'Andale Mono', 'Courier New', Courier, monospace;">Andale Mono</span>
        </label><br>
        <label>
            <input type="radio" name="fvch-font-family" value="Courier" id="fvch-font-family_1" <?php \checked('Courier', $this->config['fvch-font-family']) ?>>
            <span style="font-family: Courier, 'Courier New', Courier, monospace;">Courier</span>
        </label><br>
        <label>
            <input type="radio" name="fvch-font-family" value="Courier New" id="fvch-font-family_2" <?php \checked('Courier New', $this->config['fvch-font-family']) ?>>
            <span style="font-family: 'Courier New', Courier, monospace;">Courier New</span>
        </label><br>
        <label>
            <input type="radio" name="fvch-font-family" value="Menlo" id="fvch-font-family_3" <?php \checked('Menlo', $this->config['fvch-font-family']) ?>>
            <span style="font-family: 'Menlo', 'Courier New', Courier, monospace;">Menlo</span>
        </label><br>
        <label>
            <input type="radio" name="fvch-font-family" value="Monaco" id="fvch-font-family_4" <?php \checked('Monaco', $this->config['fvch-font-family']) ?>>
            <span style="font-family: 'Monaco', 'Courier New', Courier, monospace;">Monaco</span>
        </label>
        <?php
    }

    public function fontSize()
    {
        ?>
        <select name="fvch-font-size" id="fvch-font-size">
            <?php for ($i = .5; $i < 2.1; $i += .1) : ?>
                <option <?php \selected($this->config['fvch-font-size'], $i) ?> value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
        </select>
        <label for="fvch-font-size"><code>em</code></label>
        <p class="description"><?php \_e('Using a font-size greater than 17px in combination with the notepaper background might cause display issues.', 'fvch') ?></p>
        <?php
    }

    public function backgroundSection()
    {
    }

    public function background()
    {
        ?>
        <label class="fvch-background-option description notepaper">
            <input type="radio" name="fvch-background" value="notepaper" id="fvch-background_0" <?php \checked('notepaper', $this->config['fvch-background']) ?>>
            <span class="fvch-background-example fvch-notepaper"></span>
            <span><?php \_e('Notepaper', 'fvch') ?></span>
        </label>
        <label class="fvch-background-option description white">
            <input type="radio" name="fvch-background" value="white" id="fvch-background_1" <?php \checked('white', $this->config['fvch-background']) ?>>
            <span class="fvch-background-example fvch-white"></span>
            <span><?php \_e('White', 'fvch') ?></span>
        </label>
        <label class="fvch-background-option description custom">
            <input type="radio" name="fvch-background" value="custom" id="fvch-background_3" <?php \checked('custom', $this->config['fvch-background']) ?>>
            <span class="fvch-background-example fvch-custom" style="background-color: <?php \esc_attr_e($this->config['fvch-background-custom']) ?>;">
                <span id="fvch-colorpicker"></span>
            </span>
            <input type="hidden" name="fvch-background-custom" id="fvch-background-custom" value="<?php \esc_attr_e($this->config['fvch-background-custom']) ?>">
            <span><?php \_e('Custom', 'fvch') ?></span>
        </label>

        <br style="clear: both;">
        <?php
    }

    public function utilitySection()
    {
    }

    public function lineNumbers()
    {
        echo $this->checkbox(
            'fvch-line-numbers',
            \__('Check to enable line numbers.', 'fvch'),
            $this->config['fvch-line-numbers']
        );
    }

    public function toolbox()
    {
        echo $this->checkbox(
            'fvch-toolbox',
            \__('Check to enable the toolbox.', 'fvch'),
            $this->config['fvch-toolbox']
        );
    }

    public function darkMode()
    {
        echo $this->checkbox(
            'fvch-dark-mode',
            \__('Check to use dark mode.', 'fvch'),
            $this->config['fvch-dark-mode'],
            \__('Note: Dark Mode will override the background options.', 'fvch')
        );
    }

    /**
     * @param mixed $currentValue
     */
    private function checkbox(
        string $name,
        string $label,
        $currentValue,
        string $description = null
    ): string {
        if ($description !== null) {
            $description = \sprintf('<p class="description">%s</p>', $description);
        }

        /** @noinspection HtmlUnknownAttribute */
        return \sprintf(
            '<label>
                <input type="checkbox" name="%s" id="%s" value="1" %s>
                %s
            </label>%s',
            $name,
            $name,
            \checked('1', $currentValue, false),
            $label,
            $description ?? ''
        );
    }
}
