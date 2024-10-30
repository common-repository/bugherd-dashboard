<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Bugherd Dashboard
 * @author    Brandon Lavigne <brandon@caavadesign.com>
 * @license   GPL-2.0+
 * @link      http://github.com/drrobotnik
 * @copyright Brandon Lavigne
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}