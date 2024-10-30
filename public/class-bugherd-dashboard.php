<?php
/**
 * Plugin Name.
 *
 * @package   Bugherd_Dashboard
 * @author    Brandon Lavigne <brandon@caavadesign.com>
 * @license   GPL-2.0+
 * @link      http://github.com/drrobotnik
 * @copyright Brandon Lavigne
 */

/**
 * @package Bugherd_Dashboard
 * @author  Brandon Lavigne <brandon@caavadesign.com>
 */
class Bugherd_Dashboard {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * The variable name is used as the text domain.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'bugherd-dashboard';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_footer', array( $this, 'display_bugherd' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
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
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		
		$plugin_slug = $this->plugin_slug;
		delete_option( $plugin_slug );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	public static function display_bugherd(){

		$plugin = Bugherd_Dashboard::get_instance();
		$plugin_slug = $plugin->get_plugin_slug();
		$bugherd_settings = get_option( $plugin_slug );

		$script_install = $bugherd_settings['script_install'];
	
		if( empty($script_install) )
			return false;

		$settings = $plugin->get_remote_project_settings();
		$settings = json_decode($settings,true);
		$settings = $settings['project'];

		if( ! $settings["is_active"] || empty( $settings["api_key"] ) )
			return false;

		$embed_code = '<script type="text/javascript">
	(function (d,t) {
		var bh = d.createElement(t), s =
		d.getElementsByTagName(t)[0];
		bh.type = "text/javascript";
		bh.src = "//www.bugherd.com/sidebarv2.js?apikey='.$settings["api_key"].'";
		s.parentNode.insertBefore(bh, s);
	})(document, "script");
	</script>';


		echo $embed_code;
	}

	public static function get_remote_project_settings(){

		$plugin = Bugherd_Dashboard::get_instance();

		$plugin_slug = $plugin->get_plugin_slug();

		$bugherd_settings = get_option( $plugin_slug );

		$script_install = $bugherd_settings['script_install'];
		$project_id = $bugherd_settings['project_id'];
		$api_key = $bugherd_settings['api_key'];
	
		if( empty($script_install) || empty($project_id) || empty($api_key) )
			return false;

		$url = 'https://www.bugherd.com/api_v2/projects/'.$project_id.'/';

		$headers = array( 'Authorization' => 'Basic ' . base64_encode( "$api_key" ) );
		$result = self::remote_get(
			'bugherd_project_'.$project_id.'_settings', 
			$url, 
			array( 'headers' => $headers ), 
			$expiration = DAY_IN_SECONDS );

		return $result;
	}

	public function remote_get($key, $url, $args = array(), $expiration = 604800 ){

		if( empty( $expiration ) ){
			$results = get_option( $key );
		}else{
			$results = get_transient( $key );
		}

		if ( false === $results ) {
			$response = wp_remote_get($url, $args);
			$status = wp_remote_retrieve_response_code( $response );
			

			if($status == 200){

				$body = wp_remote_retrieve_body( $response );

				if(!$expiration){
					update_option( $key, $body );
				}else{
					set_transient($key, $body, $expiration);
				}
				
				return $body;
			}else{
				return wp_remote_retrieve_response_message( $response );
			}
		}
		return $results;
	}

}
