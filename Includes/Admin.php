<?php

/**
 *	Admin.php
 *
 *	Configuration page
 *
 *	@version	2.0
 *	@author		Frank Verhoeven
 */


if (!current_user_can('edit_themes')) {
	wp_die(__('You do not have sufficient permissions to manage options for this site.'));
}

if ('post' == strtolower($_SERVER['REQUEST_METHOD']) && check_admin_referer('fvch')) {
	foreach (FvCodeHighlighter_Config_Default::getConfig() as $key=>$default) {
		if (isset($_POST[ $key ])) {
			update_option($key, $_POST[ $key ]);
		}
	}
	if (!isset($_POST['fvch-line-numbers'])) {
		update_option('fvch-line-numbers', '0');
	}
}


?>
<div class="wrap">
	<?php screen_icon(); ?><h2><?php _e('FV Code Highlighter Options'); ?></h2>
	<?php settings_errors(); ?>
	
	<form method="post" action="themes.php?page=fv-code-highlighter-control">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Font', 'fvch'); ?></th>
				<td>
					<label>
						<input type="radio" name="fvch-font-family" value="Andale Mono" id="fvch-font-family_0" <?php checked('Andale Mono', get_option('fvch-font-family')); ?> />
						<span style="font-family: 'Andale Mono', Courier New', Courier, monospace;">Andale Mono</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Courier" id="fvch-font-family_1" <?php checked('Courier', get_option('fvch-font-family')); ?> />
						<span style="font-family: Courier, 'Courier New', Courier, monospace;">Courier</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Courier New" id="fvch-font-family_2" <?php checked('Courier New', get_option('fvch-font-family')); ?> />
						<span style="font-family: 'Courier New', Courier, monospace;">Courier New</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Menlo" id="fvch-font-family_3" <?php checked('Menlo', get_option('fvch-font-family')); ?> />
						<span style="font-family: 'Menlo', 'Courier New', Courier, monospace;">Menlo</span>
					</label><br />
					<label>
						<input type="radio" name="fvch-font-family" value="Monaco" id="fvch-font-family_4" <?php checked('Monaco', get_option('fvch-font-family')); ?> />
						<span style="font-family: 'Monaco', 'Courier New', Courier, monospace;">Monaco</span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fvch-font-size"><?php _e('Font Size', 'fvch'); ?></label></th>
				<td>
					<select name="fvch-font-size" id="fvch-font-size">
					<?php for ($i=1; $i<=20; $i++) : ?>
						<option <?php selected(get_option('fvch-font-size'), $i); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					px
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Background', 'fvch'); ?></th>
				<td>
					<label class="fvch-background-option description">
						<input type="radio" name="fvch-background" value="notepaper" id="fvch-background_0" <?php checked('notepaper', get_option('fvch-background')); ?> />
						<div class="fvch-background-example fvch-notepaper"></div>
						<span>Notepaper</span>
					</label>
					<label class="fvch-background-option description">
						<input type="radio" name="fvch-background" value="white" id="fvch-background_1" <?php checked('white', get_option('fvch-background')); ?> />
						<div class="fvch-background-example fvch-white"></div>
						<span>White</span>
					</label>
					
					<br style="clear: both;" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Line Numbers', 'fvch'); ?></th>
				<td>
					<label>
						<input type="checkbox" name="fvch-line-numbers" id="fvch-line-numbers" <?php checked('1', get_option('fvch-line-numbers')); ?> value="1" />
						<?php _e('Check this box to enable line numbers.', 'fvch'); ?>
					</label>
				</td>
			</tr>
		</table>
		
		<?php wp_nonce_field('fvch'); ?>
		
		<?php submit_button(); ?>
	</form>
	
</div>
