<?php
/*
 * Plugin Name: 	WooCommerce Advanced Free Shipping
 * Plugin URI: 		https://wordpress.org/plugins/woocommerce-advanced-free-shipping/
 * Description: 	WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.
 * Version: 		1.0.11
 * Author: 			Jeroen Sormani
 * Author URI: 		http://jeroensormani.com/
 * Text Domain: 	woocommerce-advanced-free-shipping

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
 * Class Woocommerce_Advanced_Free_Shipping.
 *
 * Main WAFS class, add filters and handling all other files.
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
	public $version = '1.0.11';


	/**
	 * File.
	 *
	 * @since 1.0.8
	 * @var string $file Main plugin file path.
	 */
	public $file = __FILE__;


	/**
	 * Instance of WooCommerce_Advanced_Free_Shipping.
	 *
	 * @since 1.0.3
	 * @access private
	 * @var object $instance The instance of WAFS.
	 */
	private static $instance;


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

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
	 * @return  object  Instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * Init.
	 *
	 * Initialize plugin parts.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Add hooks/filters
		$this->hooks();

		// Load textdomain
		$this->load_textdomain();

		// Updater
		$this->update();

		// Functions
		require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';

		/**
		 * Require matching conditions hooks.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-match-conditions.php';
		$this->matcher = new Wafs_Match_Conditions();

		/**
		 * Require file with settings.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-post-type.php';
		$this->post_type = new WAFS_post_type();

		/**
		 * Load ajax methods
		 */
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-ajax.php';
		$this->ajax = new WAFS_Ajax();

		/**
		 * Admin class
		 */
		if ( is_admin() ) :
			require_once plugin_dir_path( __FILE__ ) . 'includes/admin/admin-functions.php';

			require_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-wafs-admin.php';
			$this->admin = new WAFS_Admin();
		endif;

	}


	/**
	 * Update.
	 *
	 * Runs when the plugin is updated and checks if there should be
	 * any data updated to be compatible for the new version.
	 *
	 * @since 1.0.3
	 */
	public function update() {

		$db_version = get_option( 'wafs_plugin_version', '1.0.0' );

		// Stop current version is up to date
		if ( $db_version >= $this->version ) :
			return;
		endif;

		// Update functions for 1.0.3/1.0.5
		if ( version_compare( '1.0.3', $db_version ) || version_compare( '1.0.5', $db_version ) ) :

			$wafs_method_settings = get_option( 'woocommerce_advanced_free_shipping_settings' );
			if ( isset( $wafs_method_settings['hide_other_shipping_when_available'] ) ) :
				$wafs_method_settings['hide_other_shipping'] = $wafs_method_settings['hide_other_shipping_when_available'];
				update_option( 'woocommerce_advanced_free_shipping_settings', $wafs_method_settings );
			endif;

		endif;

		update_option( 'wafs_plugin_version', $this->version );

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

		/**
		 * WAFS shipping method
		 */
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-method.php';
		$this->was_method = new Wafs_Free_Shipping_Method();

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
	 * Enqueue scripts.
	 *
	 * Enqueue javascript and stylesheets to the admin area.
	 *
	 * @since 1.0.0
	 */
	public function wafs_admin_enqueue_scripts() {

		_deprecated_function( __FUNCTION__, '1.0.8', 'WAFS()->admin->admin_enqueue_script()' );

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
 * @return  object  WooCommerce_Advanced_Free_Shipping class object.
 */
if ( ! function_exists( 'WAFS' ) ) :

	function WAFS() {

		return WooCommerce_Advanced_Free_Shipping::instance();

	}


endif;

WAFS();
