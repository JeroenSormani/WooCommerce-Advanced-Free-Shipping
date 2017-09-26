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
		// Initialize class
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

		global $pagenow;
		if ( 'plugins.php' == $pagenow ) :
			add_filter( 'plugin_action_links_' . plugin_basename( WAFS()->file ), array( $this, 'add_plugin_action_links' ), 10, 2 );
		endif;

	}


	/**
	 * Enqueue scripts.
	 *
	 * Enqueue javascript and stylesheets to the admin area.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {

		wp_register_style( 'woocommerce-advanced-free-shipping', plugins_url( 'assets/css/woocommerce-advanced-free-shipping.min.css', WAFS()->file ), array(), WAFS()->version );

		if (
			( isset( $_REQUEST['post'] ) && 'wafs' == get_post_type( $_REQUEST['post'] ) ) ||
			( isset( $_REQUEST['post_type'] ) && 'wafs' == $_REQUEST['post_type'] ) ||
			( isset( $_REQUEST['section'] ) && 'advanced_free_shipping' == $_REQUEST['section'] )
		) :

			wp_localize_script( 'wp-conditions', 'wpc2', array(
				'action_prefix' => 'wafs_',
			) );

			wp_enqueue_style( 'woocommerce-advanced-free-shipping' );
			wp_enqueue_script( 'wp-conditions' );

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


	/**
	 * Plugin action links.
	 *
	 * Add links to the plugins.php page below the plugin name
	 * and besides the 'activate', 'edit', 'delete' action links.
	 *
	 * @since 1.0.10
	 *
	 * @param   array   $links  List of existing links.
	 * @param   string  $file   Name of the current plugin being looped.
	 * @return  array           List of modified links.
	 */
	public function add_plugin_action_links( $links, $file ) {

		if ( $file == plugin_basename( WAFS()->file ) ) :
			$links = array_merge( array(
				'<a href="' . esc_url( admin_url( '/admin.php?page=wc-settings&tab=shipping&section=advanced_free_shipping' ) ) . '">' . __( 'Settings', 'woocommerce-advanced-free-shipping' ) . '</a>'
			), $links );
		endif;

		return $links;

	}


}
