<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAFS_Admin.
 *
 * Admin class handles all admin related business.
 *
 * @class		PRE_Class
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

		// Add to WC Screen IDs to load scripts.
		add_filter( 'woocommerce_screen_ids', array( $this, 'add_was_screen_ids' ) );

		// Keep WC menu open while in WAS edit screen
		add_action( 'admin_head', array( $this, 'menu_highlight' ) );

	}



	/**
	 * Screen IDs.
	 *
	 * Add 'was' to the screen IDs so the WooCommerce scripts are loaded.
	 *
	 * @since 1.0.8
	 *
	 * @param 	array	$screen_ids	List of existing screen IDs.
	 * @return 	array 				List of modified screen IDs.
	 */
	public function add_was_screen_ids( $screen_ids ) {

		$screen_ids[] = 'was';

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
			$parent_file = 'woocommerce';
			$submenu_file = 'wc-settings';
		endif;

	}


}
