<?PHP
/*
Plugin Name: Woocommerce Advanced Free Shipping
Plugin URI: http://www.jeroensormani.com/
Donate link: http://www.jeroensormani.com/donate/
Description: WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.
Version: 1.0.1
Author: Jeroen Sormani
Author URI: http://www.jeroensormani.com/
Text Domain: wafs

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


/**
 *	Class Woocommerce_Advanced_Free_Shipping
 *
 *	Main WAFS class, add filters and handling all other files
 *
 *	@class       Woocommerce_Advanced_Free_Shipping
 *	@version     1.0.0
 *	@author      Jeroen Sormani
 */
class Woocommerce_Advanced_Free_Shipping {


	/**
	 * __construct functon.
	 */
	public function __construct() {
		
		// check if woocommerce is activated
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
			return;
		
		$this->wafs_hooks();

	}
	
	
	/**
	 * wafs_hooks functon.
	 *
	 * Initialize all hooks
	 */
	public function wafs_hooks() {
		
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
	 * wafs_free_shipping functon.
	 *
	 * 
	 */
	public function wafs_free_shipping() {
		
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-method.php';
		
	}
	
	
	/**
	 * wafs_add_shipping_method functon.
	 *
	 * 
	 */
	public function wafs_add_shipping_method( $methods ) {
		
		if ( class_exists( 'Wafs_Free_Shipping_Method' ) )
			$methods[] = 'Wafs_Free_Shipping_Method';

		return $methods;
		
	}
	
	
	/**
	 * Register post type 'wafs'.
	 */
	public function wafs_register_post_type() {

		/**
		 * Require file with settings
		 */
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wafs-post-type.php';

	}
	
	/**
	 * Enqueue style and java scripts.
	 */	
	public function wafs_admin_enqueue_scripts() {
		
		wp_enqueue_style( 'wafs-style', plugins_url( 'assets/css/admin-style.css', __FILE__ ) );
		wp_enqueue_script( 'wafs-js', plugins_url( 'assets/js/wafs-js.js', __FILE__ ), array( 'jquery' ), false, true );
		
	}
	
}
$wafs = new Woocommerce_Advanced_Free_Shipping();

/**
 * Require matching conditions hooks
 */
require_once plugin_dir_path( __FILE__ ) . '/includes/class-wafs-match-conditions.php';
?>