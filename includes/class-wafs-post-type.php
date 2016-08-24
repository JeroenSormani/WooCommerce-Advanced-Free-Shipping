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
		add_action( 'save_post', array( $this, 'save_condition_meta' ) );

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
			'name'               => __( 'Advanced Free Shipping methods', 'woocommerce-advanced-free-shipping' ),
			'singular_name'      => __( 'Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
			'add_new'            => __( 'Add New', 'woocommerce-advanced-free-shipping' ),
			'add_new_item'       => __( 'Add New Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
			'edit_item'          => __( 'Edit Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
			'new_item'           => __( 'New Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
			'view_item'          => __( 'View Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
			'search_items'       => __( 'Search Advanced Free Shipping methods', 'woocommerce-advanced-free-shipping' ),
			'not_found'          => __( 'No Advanced Free Shipping methods', 'woocommerce-advanced-free-shipping' ),
			'not_found_in_trash' => __( 'No Advanced Free Shipping methods found in Trash', 'woocommerce-advanced-free-shipping' ),
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
			1  => __( 'Free shipping method updated.', 'woocommerce-advanced-free-shipping' ),
			2  => __( 'Custom field updated.', 'woocommerce-advanced-free-shipping' ),
			3  => __( 'Custom field deleted.', 'woocommerce-advanced-free-shipping' ),
			4  => __( 'Free shipping method updated.', 'woocommerce-advanced-free-shipping' ),
			6  => __( 'Free shipping method published.', 'woocommerce-advanced-free-shipping' ),
			7  => __( 'Free shipping method saved.', 'woocommerce-advanced-free-shipping' ),
			8  => __( 'Free shipping method submitted.', 'woocommerce-advanced-free-shipping' ),
			9  => sprintf(
				__( 'Free shipping method scheduled for: <strong>%1$s</strong>.', 'woocommerce-advanced-free-shipping' ),
				date_i18n( __( 'M j, Y @ G:i', 'woocommerce-advanced-free-shipping' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Free shipping method draft updated.', 'woocommerce-advanced-free-shipping' ),
		);

		if ( 'wafs' == $post_type ) :
			$overview_link = admin_url( 'admin.php?page=wc-settings&tab=shipping&section=wafs_free_shipping_method' );

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

	}


	/**
	 * Render meta box.
	 *
	 * Render and display the condition meta box contents.
	 *
	 * @since 1.0.0
	 */
	public function render_wafs_conditions() {

		/**
		 * Load meta box conditions view.
		 */
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

		/**
		 * Load meta box settings view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/views/meta-box-settings.php';

	}


	/**
	 * Save conditions meta box.
	 *
	 * Validate and save post meta from conditions meta box.
	 *
	 * @since 1.0.0
	 */
	public function save_condition_meta( $post_id ) {

		if ( ! isset( $_POST['wafs_settings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['wafs_settings_meta_box_nonce'], 'wafs_settings_meta_box' ) ) :
			return $post_id;
		endif;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
			return $post_id;
		endif;

		if ( ! current_user_can( 'manage_woocommerce' ) ) :
			return $post_id;
		endif;

		$shipping_method_conditions = $_POST['conditions'];

		update_post_meta( $post_id, '_wafs_shipping_method_conditions', $shipping_method_conditions );

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
