<?php

/**
 * FvCodeHighlighter_Admin_Options
 *
 * @author Frank Verhoeven <info@frank-verhoeven.com>
 */
class FvCodeHighlighter_Admin_Options
{
    /**
     * Options Handler
     * @var FvCodeHighlighter_Options
     */
    protected $_options;

    /**
     * Constructor.
     *
     * @param FvCodeHighlighter_Options $options
     * @return void
     */
    public function __construct(FvCodeHighlighter_Options $options)
    {
        if (!current_user_can('edit_themes')) {
            wp_die( __('You do not have sufficient permissions to manage options for this site.') );
        }

        $this->_options = $options;
    }

    /**
     * Update the options.
     *
     * @return \FvCodeHighlighter_Admin_Options
     */
    public function updateOptions()
    {
        check_admin_referer('fvch');

        foreach ($this->_options->getDefaultOptions() as $key=>$default) {
            if (isset($_POST[ $key ])) {
                $this->_options->updateOption($key, $_POST[ $key ]);
            }
        }

        if (!isset($_POST['fvch-line-numbers'])) {
            $this->_options->updateOption('fvch-line-numbers', '0');
        }
        if (!isset($_POST['fvch-toolbox'])) {
            $this->_options->updateOption('fvch-toolbox', '0');
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
	<?php screen_icon(); ?><h2><?php _e('FV Code Highlighter Options'); ?></h2>
	<?php settings_errors(); ?>

    <div class="fvch-support">
        <form class="donate-form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input name="cmd" type="hidden" value="_s-xclick" /> <input name="encrypted" type="hidden" value="-----BEGIN PKCS7-----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-----END PKCS7-----" />
            <p>
                <?php _e('Please consider supporting this plugin', 'fvch'); ?><br />
                <input name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" type="image" />
            </p>
        </form>
    </div>

	<form method="post" action="themes.php?page=fvch-options">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Font', 'fvch'); ?></th>
				<td>
					<label>
						<input type="radio" name="fvch-font-family" value="Andale Mono" id="fvch-font-family_0" <?php checked('Andale Mono', $this->_options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Andale Mono', Courier New', Courier, monospace;">Andale Mono</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Courier" id="fvch-font-family_1" <?php checked('Courier', $this->_options->getOption('fvch-font-family')); ?> />
						<span style="font-family: Courier, 'Courier New', Courier, monospace;">Courier</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Courier New" id="fvch-font-family_2" <?php checked('Courier New', $this->_options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Courier New', Courier, monospace;">Courier New</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Menlo" id="fvch-font-family_3" <?php checked('Menlo', $this->_options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Menlo', 'Courier New', Courier, monospace;">Menlo</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Monaco" id="fvch-font-family_4" <?php checked('Monaco', $this->_options->getOption('fvch-font-family')); ?> />
						<span style="font-family: 'Monaco', 'Courier New', Courier, monospace;">Monaco</span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fvch-font-size"><?php _e('Font Size', 'fvch'); ?></label></th>
				<td>
					<select name="fvch-font-size" id="fvch-font-size">
					<?php for ($i=9; $i<=13; $i++) : ?>
						<option <?php selected($this->_options->getOption('fvch-font-size'), $i); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					px
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Background', 'fvch'); ?></th>
				<td>
					<label class="fvch-background-option description notepaper">
						<input type="radio" name="fvch-background" value="notepaper" id="fvch-background_0" <?php checked('notepaper', $this->_options->getOption('fvch-background')); ?> />
						<div class="fvch-background-example fvch-notepaper"></div>
						<span><?php _e('Notepaper', 'fvch'); ?></span>
					</label>
					<label class="fvch-background-option description white">
						<input type="radio" name="fvch-background" value="white" id="fvch-background_1" <?php checked('white', $this->_options->getOption('fvch-background')); ?> />
						<div class="fvch-background-example fvch-white"></div>
						<span><?php _e('White', 'fvch'); ?></span>
					</label>
					<label class="fvch-background-option description custom">
						<input type="radio" name="fvch-background" value="custom" id="fvch-background_3" <?php checked('custom', $this->_options->getOption('fvch-background')); ?> />
						<div class="fvch-background-example fvch-custom" style="background-color: <?php esc_attr_e( $this->_options->getOption('fvch-background-custom') ); ?>;">
                            <div id="fvch-colorpicker"></div>
                        </div>
                        <input type="hidden" name="fvch-background-custom" id="fvch-background-custom" value="<?php esc_attr_e( $this->_options->getOption('fvch-background-custom') ); ?>" />
						<span><?php _e('Custom', 'fvch'); ?></span>
					</label>

					<br style="clear: both;" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Line Numbers', 'fvch'); ?></th>
				<td>
					<label>
						<input type="checkbox" name="fvch-line-numbers" id="fvch-line-numbers" <?php checked('1', $this->_options->getOption('fvch-line-numbers')); ?> value="1" />
						<?php _e('Check to enable line numbers.', 'fvch'); ?>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Toolbox', 'fvch'); ?></th>
				<td>
					<label>
						<input type="checkbox" name="fvch-toolbox" id="fvch-toolbox" <?php checked('1', $this->_options->getOption('fvch-toolbox')); ?> value="1" />
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
