<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
$settings = (array) get_option( 'sensorpress' );
if(isset($settings['enable']) && $settings['enable'] == true){
	$valid = false;

		$url = SENSORPRESS_API . "/create";
		$vf = isset($settings['verify']) ? true : false;
		$post_data = json_encode( array(
			'domain'=> home_url(), 
			'email'=>$settings['email'],
			'timezone' => get_option('timezone_string'),
			'offset'=>get_option('gmt_offset'),
			'verify'=> $vf
			));

		$response = wp_remote_post( $url, array( 'body' => $post_data ) );
		if ( is_wp_error( $response ) ) {
			echo "<p>We had a problem setting up your monitor</p>";
		} else {
			$body = wp_remote_retrieve_body($response);
			$info = json_decode( $body );
			$settings['site-key'] = $info->id;
			update_option('sensorpress', $settings );
		}

	

} else {
	if (isset($settings['site-key'])){
	
	$url = SENSORPRESS_API."/disable/". $settings['site-key'];
	$response = wp_remote_get( $url );
	if ( is_wp_error( $response ) ) {
		echo "<p>We had a problem deactivating your site monitor</p>";
	} 
}
}
$settings['verify'] = 0;


	
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<p style="width:50%;">SensorPress is currently running in a beta state. We still check your site every 15 minutes and email you if we have a problem. You should just expect to see major changes coming to the look and feel of this plugin as we roll out new stuff.</p>
	<br>
	<!-- @TODO: Provide markup for your options page here. -->
	<form method="post" action="options.php">
    <?php settings_fields( $this->plugin_slug . '-settings-group' ); ?>
    <?php do_settings_sections( $this->plugin_slug . '-settings-group' ); 
     
    ?>

    <table class="form-table">
        <tr valign="top">
        <th scope="row">Notification Email</th>
        <td><input type="text" name="sensorpress[email]" value="<?php echo $settings['email']; ?>" /></td>
        </tr>
        
        <tr>
        <th scope="row">Site Key</th>
        <td>
         	<input type="text" name="sensorpress[site-key]" readonly value="<?php echo $settings['site-key']; ?>" />
         </td>
     </tr>
        <tr valign="top">
        <th scope="row">Enable</th>
        <td><input type="checkbox" name="sensorpress[enable]" value="1" <?php echo checked(1, $settings['enable'], false) ;?>  /></td>
        </tr>
        </tr>
        <tr valign="top">
        <th scope="row">Re-send Verification Email</th>
        <td><input type="checkbox" name="sensorpress[verify]" value="1" <?php echo checked(1, $settings['verify'], false) ;?>  /></td>
        </tr>
        
    </table>
    
    <?php submit_button(); ?>

</form>

</div>
