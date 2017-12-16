<?php

namespace FvCodeHighlighter\Admin;

use FvCodeHighlighter\Options as PluginOptions;

/**
 * Options
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
class Options
{
    /**
     * @var PluginOptions
     */
    protected $options;

    /**
     * __construct()
     *
     * @param PluginOptions $options
     */
    public function __construct(PluginOptions $options)
    {
        if (!current_user_can('edit_themes')) {
            wp_die(__('You do not have sufficient permissions to manage options for this site.'));
        }

        $this->options = $options;
    }

    /**
     * Update the options.
     *
     * @return $this
     */
    public function updateOptions()
    {
        check_admin_referer('fvch');

        foreach ($this->options->getDefaultOptions() as $key => $default) {
            if (isset($_POST[ $key ])) {
                $this->options->updateOption($key, $_POST[ $key ]);
            }
        }

        if (!isset($_POST['fvch-line-numbers'])) {
            $this->options->updateOption('fvch-line-numbers', '0');
        }
        if (!isset($_POST['fvch-toolbox'])) {
            $this->options->updateOption('fvch-toolbox', '0');
        }

        add_settings_error('fvch-options', 'fvch-updated', __('Your settings have been updated', 'fvch'), 'updated');

        return $this;
    }

    /**
     * Display the options page.
     *
     * @return void
     */
    public function displayOptions()
    {
?>
<div class="wrap fvch-options-page">
	<h2><?php _e('FV Code Highlighter Options'); ?></h2>
	<?php settings_errors(); ?>

    <div class="fvch-support">
        <a href="https://www.paypal.me/FrankVerhoeven" class="button button-primary">
            <?php _e('Support this plugin', 'fvch'); ?>
        </a>
    </div>

	<form method="post" action="themes.php?page=fvch-options">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Font', 'fvch'); ?></th>
				<td>
					<label>
						<input type="radio" name="fvch-font-family" value="Andale Mono" id="fvch-font-family_0" <?php checked('Andale Mono', $this->options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Andale Mono', 'Courier New', Courier, monospace;">Andale Mono</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Courier" id="fvch-font-family_1" <?php checked('Courier', $this->options->getOption('fvch-font-family')); ?> />
						<span style="font-family: Courier, 'Courier New', Courier, monospace;">Courier</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Courier New" id="fvch-font-family_2" <?php checked('Courier New', $this->options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Courier New', Courier, monospace;">Courier New</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Menlo" id="fvch-font-family_3" <?php checked('Menlo', $this->options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Menlo', 'Courier New', Courier, monospace;">Menlo</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Monaco" id="fvch-font-family_4" <?php checked('Monaco', $this->options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Monaco', 'Courier New', Courier, monospace;">Monaco</span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fvch-font-size"><?php _e('Font Size', 'fvch'); ?></label></th>
				<td>
					<select name="fvch-font-size" id="fvch-font-size">
					<?php for ($i = .5; $i < 2.1; $i += .1) : ?>
						<option <?php selected($this->options->getOption('fvch-font-size'), $i); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<code>em</code>
                    <p class="description"><?php _e('Using a font-size greater than 17px in combination with the notepaper background might cause display issues.', 'fvch'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Background', 'fvch'); ?></th>
				<td>
					<label class="fvch-background-option description notepaper">
						<input type="radio" name="fvch-background" value="notepaper" id="fvch-background_0" <?php checked('notepaper', $this->options->getOption('fvch-background')); ?> />
						<span class="fvch-background-example fvch-notepaper"></span>
						<span><?php _e('Notepaper', 'fvch'); ?></span>
					</label>
					<label class="fvch-background-option description white">
						<input type="radio" name="fvch-background" value="white" id="fvch-background_1" <?php checked('white', $this->options->getOption('fvch-background')); ?> />
						<span class="fvch-background-example fvch-white"></span>
						<span><?php _e('White', 'fvch'); ?></span>
					</label>
					<label class="fvch-background-option description custom">
						<input type="radio" name="fvch-background" value="custom" id="fvch-background_3" <?php checked('custom', $this->options->getOption('fvch-background')); ?> />
						<span class="fvch-background-example fvch-custom" style="background-color: <?php esc_attr_e($this->options->getOption('fvch-background-custom')); ?>;">
                            <span id="fvch-colorpicker"></span>
                        </span>
                        <input type="hidden" name="fvch-background-custom" id="fvch-background-custom" value="<?php esc_attr_e($this->options->getOption('fvch-background-custom')); ?>" />
						<span><?php _e('Custom', 'fvch'); ?></span>
					</label>

					<br style="clear: both;" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Line Numbers', 'fvch'); ?></th>
				<td>
					<label>
						<input type="checkbox" name="fvch-line-numbers" id="fvch-line-numbers" <?php checked('1', $this->options->getOption('fvch-line-numbers')); ?> value="1" />
						<?php _e('Check to enable line numbers.', 'fvch'); ?>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Toolbox', 'fvch'); ?></th>
				<td>
					<label>
						<input type="checkbox" name="fvch-toolbox" id="fvch-toolbox" <?php checked('1', $this->options->getOption('fvch-toolbox')); ?> value="1" />
						<?php _e('Check to enable the toolbox.', 'fvch'); ?>
					</label>
				</td>
			</tr>
		</table>

		<?php wp_nonce_field('fvch'); ?>

		<?php submit_button(); ?>
	</form>
</div>
<?php
    }
}
