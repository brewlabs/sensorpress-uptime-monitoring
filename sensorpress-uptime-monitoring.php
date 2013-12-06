<?php
/*
Plugin Name:       SensorPress
Version:           1.0
Plugin URI:        http://sensorpress.com
Description:       The Internet is always on. Is your website?
Author:            SensorPress
Author URI:        http://sensorpress.com
Text Domain:       sensorpress-locale
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path:       /languages
GitHub Plugin URI: https://github.com/brewlabs/sensorpress
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! defined( 'SENSORPRESS_API' ) ){
	define('SENSORPRESS_API','http://api.sensorpress.com');
}
/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * SensorPress:
 *
 * - replace `class-sensorpress.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-sensorpress.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * SensorPress:
 *
 * - replace SensorPress with the name of the class defined in
 *   `class-sensorpress.php`
 */
register_activation_hook( __FILE__, array( 'SensorPress', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SensorPress', 'deactivate' ) );

/*
 * SensorPress:
 *
 * - replace SensorPress with the name of the class defined in
 *   `class-sensorpress.php`
 */
add_action( 'plugins_loaded', array( 'SensorPress', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * SensorPress:
 *
 * - replace `class-plugin-admin.php` with the name of the plugin's admin file
 * - replace SensorPress_Admin with the name of the class defined in
 *   `class-sensorpress-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-sensorpress-admin.php' );
	add_action( 'plugins_loaded', array( 'SensorPress_Admin', 'get_instance' ) );

}
