<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAFS_Admin.
 *
 * Admin class handles all admin related business.
 *
 * @class		WAFS_Admin
 * @version		1.0.0
 * @author		Jeroen Sormani
 */
class WAFS_Admin {


	/**
	 * Constructor.
	 *
	 * @since 1.0.8
	 */
	public function __construct() {

		// Initialize plugin parts
		add_action( 'admin_init', array( $this, 'init' ) );

	}


	/**
	 * Initialize class parts.
	 *
	 * @since 1.0.8
	 */
	public function init() {

		// Enqueue scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Add to WC Screen IDs to load scripts.
		add_filter( 'woocommerce_screen_ids', array( $this, 'add_screen_ids' ) );

		// Keep WC menu open while in WAFS edit screen
		add_action( 'admin_head', array( $this, 'menu_highlight' ) );

	}


	/**
	 * Enqueue scripts.
	 *
	 * Enqueue javascript and stylesheets to the admin area.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {

		wp_register_style( 'wafs-style', plugins_url( 'assets/css/admin-style.css', WAFS()->file ), array(), WAFS()->version );
		wp_register_script( 'wafs-js', plugins_url( 'assets/js/wafs-js.js', WAFS()->file ), array( 'jquery' ), WAFS()->version, true );
		wp_localize_script( 'wafs-js', 'wafs', array(
			'nonce' => wp_create_nonce( 'wafs-ajax-nonce' ),
		) );

		if (
			( isset( $_REQUEST['post'] ) && 'wafs' == get_post_type( $_REQUEST['post'] ) ) ||
			( isset( $_REQUEST['post_type'] ) && 'wafs' == $_REQUEST['post_type'] ) ||
			( isset( $_REQUEST['section'] ) && 'wafs_free_shipping_method' == $_REQUEST['section'] )
		) :

			wp_enqueue_style( 'wafs-style' );
			wp_enqueue_script( 'wafs-js' );
			wp_dequeue_script( 'autosave' );

		endif;

	}


	/**
	 * Screen IDs.
	 *
	 * Add 'was' to the screen IDs so the WooCommerce scripts are loaded.
	 *
	 * @since 1.0.8
	 *
	 * @param   array  $screen_ids  List of existing screen IDs.
	 * @return  array               List of modified screen IDs.
	 */
	public function add_screen_ids( $screen_ids ) {

		$screen_ids[] = 'wafs';

		return $screen_ids;

	}


	/**
	 * Keep menu open.
	 *
	 * Highlights the correct top level admin menu item for post type add screens.
	 *
	 * @since 1.0.0
	 */
	public function menu_highlight() {

		global $parent_file, $submenu_file, $post_type;

		if ( 'wafs' == $post_type ) :
			$parent_file  = 'woocommerce';
			$submenu_file = 'wc-settings';
		endif;

	}


}
