<?php
// create custom plugin settings menu
add_action('admin_menu', 'endo_createoptionspage');

function endo_createoptionspage() {

	//create new top-level menu
	add_options_page('Endomondo Summary Settings', 'Endomondo-Summary', 'manage_options', 'endomondo-options', 'endotom_build_admin');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'endomondosummary-group', 'endomondo-summary_endoid' );
	register_setting( 'endomondosummary-group', 'endomondo-summary_method' );
	register_setting( 'endomondosummary-group', 'endomondo-summary_cssloc' );
}

function endotom_build_admin() {
?>
<div class="wrap">
<h2>Endomondo Summary Options Page</h2>

<Table>
	<tr>
		<td valign="top">
			<h3>Usage:</h3>
			<p>Fill out the settings on this page and then use the shortcode: "endomondo-summary" anywhere on your site.<br />
			Eg: [endomondo-summary]<br /><br />
			If you prefer, you can overwrite these settings by applying the parameters in the shortcode: <br />
			[endomondo-summary endoid=123456 method=local cssloc=local]</p>
		
			<form method="post" action="options.php">
				<?php settings_fields( 'endomondosummary-group' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Endomondo User ID</th>
						<td><input type="text" name="endomondo-summary_endoid" value="<?php echo get_option('endomondo-summary_endoid'); ?>" /></td>
					</tr>
					 			 
					<tr valign="top">
						<th scope="row">Method</th>
						<td>
							<select name="endomondo-summary_method">
								<option value="local" <?php if (get_option('endomondo-summary_method') == 'local') echo "selected=selected" ?>>Local</option>
								<option value="iframe"  <?php if (get_option('endomondo-summary_method') == 'iframe') echo "selected=selected" ?>>iFrame</option>
							</select>	
						</td>
					</tr>
					
					<tr valign="top">
						<td colspan="2">Local - Prints the Endomondo widget as if it is part of the page. If you find you
							have CSS Issues with your site, then try the iFrame method to seporate the content.
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">CSS Location</th>
						<td>
							<select name="endomondo-summary_cssloc">
								<option value="local" <?php if (get_option('endomondo-summary_cssloc') == 'local') echo "selected=selected" ?>>Local</option>
								<option value="external"  <?php if (get_option('endomondo-summary_cssloc') == 'external') echo "selected=selected" ?>>External</option>
							</select>	
						</td>
					</tr>
					
					<tr valign="top">
							<td colspan="2">Local (recommended) uses the local CSS file which has been tidied for use with this widget.
								External snips the CSS Section from the Endomondo website including all CSS references but unneeded Javascript references also.
								<br /> <br />
								Please note the combination of CSS Location: External and Method: Local is not supported as the Endomondo CSS could modify your themes CSS.
							</td>
					</tr>
									
				</table>
			
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
		</td>
		<td valign="top" Width="30%">
			<div style="border-width: .2em; border-style: dotted; border-color: #900; padding: 15px">
				<center><b>Thank You</b></center>
				<p>Writing plugins is time consuming,
				if you really like this plugin, please consider a small donation.</p>				
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="CFEW7MXZY2B3S">
					<center><input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online."></center>
					<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
				</form>					
			</div>
		</td>
	</tr>
</table>

</div>
<?php } ?>