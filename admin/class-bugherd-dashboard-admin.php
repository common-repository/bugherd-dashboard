<?php
/**
 * Plugin Name.
 *
 * @package   Bugherd_Dashboard_Admin
 * @author    Brandon Lavigne <brandon@caavadesign.com>
 * @license   GPL-2.0+
 * @link      http://github.com/drrobotnik
 * @copyright Brandon Lavigne
 */

/**
 * @package Bugherd_Dashboard_Admin
 * @author  Brandon Lavigne <brandon@caavadesign.com>
 */
class Bugherd_Dashboard_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$plugin = Bugherd_Dashboard::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		add_action('wp_dashboard_setup', array( $this, 'add_bugherd_dashboard_widget' ) );

		add_action('wp_footer', array( $this, 'display_bugherd' ) );

	}

	public static function add_bugherd_dashboard_widget(){
		wp_add_dashboard_widget(
			'dashboard_bugherd_widget',
			__( 'Bugherd Activity' ),
			array( 'Bugherd_Dashboard_Admin', 'dashboard_bugherd_activity'),
			array( 'Bugherd_Dashboard_Admin', 'dashboard_bugherd_settings' )
		);
	}

	public static function dashboard_bugherd_settings(){
		include_once( plugin_dir_path( __DIR__ ) . 'admin/views/dashboard-activity-settings.php');
	}

	public static function dashboard_bugherd_activity(){
		include_once( plugin_dir_path( __DIR__ ) . 'admin/views/dashboard-activity.php');
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();
		if ( 'dashboard' == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Bugherd_Dashboard::VERSION );
		}

	}

}
