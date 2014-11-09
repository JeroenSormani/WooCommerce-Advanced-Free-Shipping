<?PHP
/*
Plugin Name: Woocommerce Advanced Free Shipping
Plugin URI: http://www.jeroensormani.com/
Donate link: http://www.jeroensormani.com/donate/
Description: WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.
Version: 1.0.4
Author: Jeroen Sormani
Author URI: http://www.jeroensormani.com/
Text Domain: woocommerce-advanced-free-shipping

 * Copyright Jeroen Sormani
 *
 *     This file is part of Woocommerce Advanced Free Shipping,
 *     a plugin for WordPress.
 *
 *     Woocommerce Advanced Free Shipping is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 3 of the License, or (at your option)
 *     any later version.
 *
 *     Woocommerce Advanced Free Shipping is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Class Woocommerce_Advanced_Free_Shipping
 *
 * Main WAFS class, add filters and handling all other files
 *
 * @class       Woocommerce_Advanced_Free_Shipping
 * @version     1.0.0
 * @author      Jeroen Sormani
 */
class WooCommerce_Advanced_Free_Shipping {


	/**
	 * Version.
	 *
	 * @since 1.0.4
	 * @var string $version Plugin version number.
	 */
	public $version = '1.0.4';


	/**
	 * Instace of WooCommerce_Advanced_Shipping.
	 *
	 * @since 1.0.3
	 * @access private
	 * @var object $instance The instance of WAS.
	 */
	private static $instance;


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( ! function_exists( 'is_plugin_active_for_network' ) )
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		// Check if WooCommerce is active
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
			if ( ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) :
				return;
			endif;
		endif;

		$this->init();

	}


	/**
	 * Instance.
	 *
	 * An global instance of the class. Used to retrieve the instance
	 * to use on other files/plugins/themes.
	 *
	 * @since 1.1.0
	 *
	 * @return object Instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * Update.
	 *
	 * Update function.
	 *
	 * @since 1.0.3
	 */
	public function update() {

		$db_version = get_option( 'wafs_plugin_version', '1.0.0' );

		// Stop current version is up to date
		if ( $db_version >= $this->version ) :
			return;
		endif;

		// Update functions for 1.0.3
		if ( version_compare( '1.0.3', $db_version ) ) :

			$wafs_method_settings = get_option( 'woocommerce_advanced_free_shipping_settings' );
			if ( isset( $wafs_method_settings['hide_other_shipping_when_available'] ) ) :
				$wafs_method_settings['hide_other_shipping'] = $wafs_method_settings['hide_other_shipping_when_available'];
				update_option( 'woocommerce_advanced_free_shipping_settings', $wafs_method_settings );
			endif;

		endif;

		update_option( 'wafs_plugin_version', $this->version );


	}


	/**
	 * Init.
	 *
	 * Initialize plugin parts.
	 *
	 * @since 1.1.0
	 */
	public function init() {

		// Add hooks/filters
		$this->hooks();

		// Load textdomain
		$this->load_textdomain();


		/**
		 * Require matching conditions hooks.
		 */
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wafs-match-conditions.php';

	}


	/**
	 * Hooks.
	 *
	 * Initialize all class hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {

		// Initialize shipping method class
		add_action( 'woocommerce_shipping_init', array( $this, 'wafs_free_shipping' ) );

		// Add shipping method
		add_action( 'woocommerce_shipping_methods', array( $this, 'wafs_add_shipping_method' ) );

		// Register post type
		add_action( 'init', array( $this, 'wafs_register_post_type' ) );

		// Enqueue scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'wafs_admin_enqueue_scripts' ) );

	}


	/**
	 * Textdomain.
	 *
	 * Load the textdomain based on WP language.
	 *
	 * @since 1.1.0
	 */
	public function load_textdomain() {

		// Load textdomain
		load_plugin_textdomain( 'woocommerce-advanced-free-shipping', false, basename( dirname( __FILE__ ) ) . '/languages' );

	}


	/**
	 * Shipping method.
	 *
	 * Include the WooCommerce shipping method class.
	 *
	 * @since 1.0.0
	 */
	public function wafs_free_shipping() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-method.php';

	}


	/**
	 * Add shipping method.
	 *
	 * Add shipping method to WooCommerce.
	 *
	 * @since 1.0.0
	 */
	public function wafs_add_shipping_method( $methods ) {

		if ( class_exists( 'Wafs_Free_Shipping_Method' ) ) :
			$methods[] = 'Wafs_Free_Shipping_Method';
		endif;

		return $methods;

	}


	/**
	 * WAFS post type.
	 *
	 * Class to handle post type and everything around that.
	 *
	 * @since 1.0.0
	 */
	public function wafs_register_post_type() {

		/**
		 * Require file with settings.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-post-type.php';

	}


	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 */
	public function wafs_admin_enqueue_scripts() {

		wp_enqueue_style( 'wafs-style', plugins_url( 'assets/css/admin-style.css', __FILE__ ), array(), $this->version );
		wp_enqueue_script( 'wafs-js', plugins_url( 'assets/js/wafs-js.js', __FILE__ ), array( 'jquery' ), $this->version, true );

	}


}


/**
 * The main function responsible for returning the WooCommerce_Advanced_Free_Shipping object.
 *
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php WAFS()->method_name(); ?>
 *
 * @since 1.1.0
 *
 * @return object WooCommerce_Advanced_Free_Shipping class object.
 */
if ( ! function_exists( 'WAFS' ) ) :

 	function WAFS() {
		return WooCommerce_Advanced_Free_Shipping::instance();
	}

endif;

WAFS();
