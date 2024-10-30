<?php
/**
 * @package   Bugherd_Dashboard
 * @author    Brandon Lavigne <brandon@caavadesign.com>
 * @license   GPL-2.0+
 * @link      http://github.com/drrobotnik/bugherd-dashboard
 * @copyright Brandon Lavigne
 *
 * @wordpress-plugin
 * Plugin Name:       Bugherd Dashboard
 * Plugin URI:        http://github.com/drrobotnik/bugherd-dashboard
 * Description:       A dashboard plugin to track BugHerd issue statuses within the WordPress Admin area.
 * Version:           1.0.0
 * Author:            Brandon Lavigne
 * Author URI:        http://caavadesign.com
 * Text Domain:       bugherd-dashboard-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/drrobotnik/bugherd-dashboard
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-bugherd-dashboard.php' );

register_activation_hook( __FILE__, array( 'Bugherd_Dashboard', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Bugherd_Dashboard', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Bugherd_Dashboard', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-bugherd-dashboard-admin.php' );
	add_action( 'plugins_loaded', array( 'Bugherd_Dashboard_Admin', 'get_instance' ) );

}
