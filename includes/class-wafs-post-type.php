<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Class WAFS_post_type.
 *
 * Initialize the WAFS post type.
 *
 * @class       WAFS_post_type
 * @author     	Jeroen Sormani
 * @package		WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */
class WAFS_post_type {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Register post type
		add_action( 'init', array( $this, 'register_post_type' ) );

		// Add/save meta boxes
		add_action( 'add_meta_boxes', array( $this, 'post_type_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta' ) );

		// Edit user messages
		add_filter( 'post_updated_messages', array( $this, 'custom_post_type_messages' ) );

		// Redirect after delete
		add_action( 'load-edit.php', array( $this, 'redirect_after_trash' ) );

	}


	/**
	 * Post type.
	 *
	 * Register 'wafs' post type.
	 *
	 * @since 1.0.0
	 */
	public function register_post_type() {

		$labels = array(
			'name'               => __( 'Advanced Free Shipping rates', 'woocommerce-advanced-free-shipping' ),
			'singular_name'      => __( 'Advanced Free Shipping rate', 'woocommerce-advanced-free-shipping' ),
			'add_new'            => __( 'Add New', 'woocommerce-advanced-free-shipping' ),
			'add_new_item'       => __( 'Add New Advanced Free Shipping rate', 'woocommerce-advanced-free-shipping' ),
			'edit_item'          => __( 'Edit Advanced Free Shipping rate', 'woocommerce-advanced-free-shipping' ),
			'new_item'           => __( 'New Advanced Free Shipping rate', 'woocommerce-advanced-free-shipping' ),
			'view_item'          => __( 'View Advanced Free Shipping rate', 'woocommerce-advanced-free-shipping' ),
			'search_items'       => __( 'Search Advanced Free Shipping rates', 'woocommerce-advanced-free-shipping' ),
			'not_found'          => __( 'No Advanced Free Shipping rates', 'woocommerce-advanced-free-shipping' ),
			'not_found_in_trash' => __( 'No Advanced Free Shipping rates found in Trash', 'woocommerce-advanced-free-shipping' ),
		);

		register_post_type( 'wafs', array(
			'label'              => 'wafs',
			'show_ui'            => true,
			'show_in_menu'       => false,
			'public'             => false,
			'publicly_queryable' => false,
			'capability_type'    => 'post',
			'map_meta_cap'       => true,
			'rewrite'            => false,
			'_builtin'           => false,
			'query_var'          => true,
			'supports'           => array( 'title' ),
			'labels'             => $labels,
		) );

	}


	/**
	 * Messages.
	 *
	 * Modify the notice messages text for the 'wafs' post type.
	 *
	 * @since 1.0.0
	 *
	 * @param   array  $messages  Existing list of messages.
	 * @return  array             Modified list of messages.
	 */
	function custom_post_type_messages( $messages ) {

		$post      = get_post();
		$post_type = get_post_type( $post );

		$messages['wafs'] = array(
			0  => '',
			1  => __( 'Free shipping rate updated.', 'woocommerce-advanced-free-shipping' ),
			2  => __( 'Custom field updated.', 'woocommerce-advanced-free-shipping' ),
			3  => __( 'Custom field deleted.', 'woocommerce-advanced-free-shipping' ),
			4  => __( 'Free shipping rate updated.', 'woocommerce-advanced-free-shipping' ),
			6  => __( 'Free shipping rate published.', 'woocommerce-advanced-free-shipping' ),
			7  => __( 'Free shipping rate saved.', 'woocommerce-advanced-free-shipping' ),
			8  => __( 'Free shipping rate submitted.', 'woocommerce-advanced-free-shipping' ),
			9  => sprintf(
				__( 'Free shipping method scheduled for: <strong>%1$s</strong>.', 'woocommerce-advanced-free-shipping' ),
				date_i18n( __( 'M j, Y @ G:i', 'woocommerce-advanced-free-shipping' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Free shipping rate draft updated.', 'woocommerce-advanced-free-shipping' ),
		);

		if ( 'wafs' == $post_type ) :
			$overview_link = admin_url( 'admin.php?page=wc-settings&tab=shipping&section=advanced_free_shipping' );

			$overview                    = sprintf( ' <a href="%s">%s</a>', esc_url( $overview_link ), __( 'Return to overview.', 'woocommerce-advanced-free-shipping' ) );
			$messages[ $post_type ][1]  .= $overview;
			$messages[ $post_type ][6]  .= $overview;
			$messages[ $post_type ][9]  .= $overview;
			$messages[ $post_type ][8]  .= $overview;
			$messages[ $post_type ][10] .= $overview;

		endif;

		return $messages;

	}


	/**
	 * Add meta boxes.
	 *
	 * Add two meta boxes to WAFS with conditions and settings.
	 *
	 * @since 1.0.0
	 */
	public function post_type_meta_box() {

		add_meta_box( 'wafs_conditions', __( 'Advanced Free Shipping conditions', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_conditions' ), 'wafs', 'normal' );
		add_meta_box( 'wafs_settings', __( 'Shipping settings', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_settings' ), 'wafs', 'normal' );
		add_meta_box( 'wafs_resources', __( 'Useful links', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_resources' ), 'wafs', 'side' );

	}


	/**
	 * Render meta box.
	 *
	 * Render and display the condition meta box contents.
	 *
	 * @since 1.0.0
	 */
	public function render_wafs_conditions() {
		require_once plugin_dir_path( __FILE__ ) . 'admin/views/meta-box-conditions.php';
	}


	/**
	 * Render meta box.
	 *
	 * Render and display the settings meta box conditions.
	 *
	 * @since 1.0.0
	 */
	public function render_wafs_settings() {
		require_once plugin_dir_path( __FILE__ ) . 'admin/views/meta-box-settings.php';
	}


	/**
	 * Show resources MB contents.
	 *
	 * @since 1.1.3
	 */
	function render_wafs_resources() {

		?><ul>
			<li><a href="http://jeroensormani.com/how-the-advanced-plugin-conditions-work?utm_source=WAFS-plugin&utm_medium=website&utm_campaign=WAFS-helpful-links" target="_blank"><?php _e( 'How the conditions work', 'woocommerce-advanced-free-shipping' ); ?></a></li>
			<li><a href="http://jeroensormani.com/apply-free-shipping-for-specific-products-in-woocommerce?utm_source=WAFS-plugin&utm_medium=website&utm_campaign=WAFS-helpful-links" target="_blank"><?php _e( 'Applying free shipping to specific products', 'woocommerce-advanced-free-shipping' ); ?></a></li>
			<li><a href="http://jeroensormani.com/showing-add-10-free-shipping-notice#showing-a-free-shipping-notice-for-advanced-shipping?utm_source=WAFS-plugin&utm_medium=website&utm_campaign=WAFS-helpful-links" target="_blank"><?php _e( 'Showing a free shipping message', 'woocommerce-advanced-free-shipping' ); ?></a></li>
			<li><a href="http://jeroensormani.com/shipping-debug-mode?utm_source=WAFS-plugin&utm_medium=website&utm_campaign=WAFS-helpful-links" target="_blank"><?php _e( 'Disabling the shipping cache', 'woocommerce-advanced-free-shipping' ); ?></a></li>
			<li><a href="http://codecanyon.net/item/woocommerce-advanced-shipping/8634573" target="_blank"><?php _e( 'Apply shipping cost using conditions', 'woocommerce-advanced-free-shipping' ); ?></a></li>
			<hr />
			<li><a href="http://jeroensormani.com/contact?utm_source=WAFS-plugin&utm_medium=website&utm_campaign=WAFS-helpful-links" target="_blank"><?php _e( 'Hire me for custom condition development', 'woocommerce-advanced-free-shipping' ); ?></a></li>
		</ul><?php

	}


	/**
	 * Save settings meta box.
	 *
	 * Validate and save post meta from settings meta box.
	 *
	 * @since 1.0.0
	 */
	public function save_meta( $post_id ) {

		if ( ! isset( $_POST['wafs_settings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['wafs_settings_meta_box_nonce'], 'wafs_settings_meta_box' ) ) :
			return $post_id;
		endif;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
			return $post_id;
		endif;

		if ( ! current_user_can( 'manage_woocommerce' ) ) :
			return $post_id;
		endif;

		$shipping_method = array_map( 'sanitize_text_field', $_POST['_wafs_shipping_method'] );
		update_post_meta( $post_id, '_wafs_shipping_method', $shipping_method );

		// Save sanitized conditions
		update_post_meta( $post_id, '_wafs_shipping_method_conditions', wpc_sanitize_conditions( $_POST['conditions'] ) );

	}


	/**
	 * Redirect trash.
	 *
	 * Redirect user after trashing a WAFS post.
	 *
	 * @since 1.0.0
	 */
	public function redirect_after_trash() {

		$screen = get_current_screen();

		if ( 'edit-wafs' == $screen->id ) :

			if ( isset( $_GET['trashed'] ) &&  intval( $_GET['trashed'] ) > 0 ) :

				wp_redirect( admin_url( '/admin.php?page=wc-settings&tab=shipping&section=wafs_free_shipping_method' ) );
				exit();

			endif;

		endif;

	}


}

/**
 * Load condition object
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/class-wafs-condition.php';
