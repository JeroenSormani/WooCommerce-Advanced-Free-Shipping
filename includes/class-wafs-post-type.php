<?php
/**
 * Class Wafs_post_type
 *
 * Initialize the WAFS post type
 *
 * @class       Wafs_post_type
 * @author     	Jeroen Sormani
 * @package		WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wafs_Post_Type {
	
	
	/**
	 * __construct functon.
	 *
	 * 
	 */
	public function __construct() {
		 
		 $this->wafs_register_post_type();

		 add_action( 'add_meta_boxes', array( $this, 'wafs_post_type_meta_box' ) );
		 add_action( 'save_post', array( $this, 'wafs_save_meta' ) );
		 add_action( 'save_post', array( $this, 'wafs_save_condition_meta' ) );

		 // Edit user notices
		 add_filter( 'post_updated_messages', array( $this, 'wafs_custom_post_type_messages' ) );
		 
	 }
	 
	 
	/**
	 * Register the wafs post type
	 */
	public function wafs_register_post_type() {
		
		$labels = array(
		    'name' 					=> __( 'Advanced Free Shipping methods', 'woocommerce-advanced-free-shipping' ),
			'singular_name' 		=> __( 'Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
		    'add_new' 				=> __( 'Add New', 'woocommerce-advanced-free-shipping' ),
		    'add_new_item' 			=> __( 'Add New Advanced Free Shipping method' , 'woocommerce-advanced-free-shipping' ),
		    'edit_item' 			=> __( 'Edit Advanced Free Shipping method' , 'woocommerce-advanced-free-shipping' ),
		    'new_item' 				=> __( 'New Advanced Free Shipping method' , 'woocommerce-advanced-free-shipping' ),
		    'view_item' 			=> __( 'View Advanced Free Shipping method', 'woocommerce-advanced-free-shipping' ),
		    'search_items' 			=> __( 'Search Advanced Free Shipping methods', 'woocommerce-advanced-free-shipping' ),
		    'not_found' 			=> __( 'No Advanced Free Shipping methods', 'woocommerce-advanced-free-shipping' ),
		    'not_found_in_trash'	=> __( 'No Advanced Free Shipping methods found in Trash', 'woocommerce-advanced-free-shipping' ),
		);

		register_post_type( 'wafs', array(
			'label' 				=> 'wafs',
			'show_ui' 				=> true,
			'show_in_menu' 			=> false,
			'capability_type' 		=> 'post',
			'map_meta_cap' 			=> true,
			'rewrite' 				=> array( 'slug' => 'wafs', 'with_front' => true ),
			'_builtin' 				=> false,
			'query_var' 			=> true,
			'supports' 				=> array( 'title' ),
			'labels' 				=> $labels,
		) );
		
	}
	
	
	/**
	 * Edit notice messages.
	 *
	 * @return array
	 */
	function wafs_custom_post_type_messages( $messages ) {
		
		$post 				= get_post();
		$post_type			= get_post_type( $post );
		$post_type_object	= get_post_type_object( $post_type );
		
		$messages['wafs'] = array(
			0  => '',
			1  => __( 'Free shipping method updated.', 'woocommerce-advanced-free-shipping' ),
			2  => __( 'Custom field updated.', 'woocommerce-advanced-free-shipping' ),
			3  => __( 'Custom field deleted.', 'woocommerce-advanced-free-shipping' ),
			4  => __( 'Free shipping method updated.', 'woocommerce-advanced-free-shipping' ),
			5  => isset( $_GET['revision'] ) ? 
				sprintf( __( 'Free shipping method restored to revision from %s', 'woocommerce-advanced-free-shipping' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) 
				: false,
			6  => __( 'Free shipping method published.', 'woocommerce-advanced-free-shipping' ),
			7  => __( 'Free shipping method saved.', 'woocommerce-advanced-free-shipping' ),
			8  => __( 'Free shipping method submitted.', 'woocommerce-advanced-free-shipping' ),
			9  => sprintf(
				__( 'Free shipping method scheduled for: <strong>%1$s</strong>.', 'woocommerce-advanced-free-shipping' ),
				date_i18n( __( 'M j, Y @ G:i', 'woocommerce-advanced-free-shipping' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Free shipping method draft updated.', 'woocommerce-advanced-free-shipping' ),
		);
		
		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );
	
			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Free shipping method', 'woocommerce-advanced-free-shipping' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;
	
			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Free shipping method', 'woocommerce-advanced-free-shipping' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}
		
		return $messages;
		
	}

	
	/**
	 * wafs_post_type_meta_box functon.
	 */
	public function wafs_post_type_meta_box() {
		
		add_meta_box( 'wafs_conditions', __( 'Advanced Free Shipping conditions', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_conditions' ), 'wafs', 'normal' );
		add_meta_box( 'wafs_settings', __( 'Shipping settings', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_settings' ), 'wafs', 'normal' );
		
	}
	
	
	/**
	 * wafs_conditions_callback functon.
	 */
	public function render_wafs_conditions() {
		
		/**
		 * Load meta box conditions view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings/meta-box-conditions.php';
		
	}
	
	
	/**
	 * wafs_settings_callback functon.
	 */
	public function render_wafs_settings() {
		
		/**
		 * Load meta box settings view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings/meta-box-settings.php';
		
	}
	
	
	/**
	 * wafs_save_meta functon.
	 *
	 * Validate and save post meta
	 */
	public function wafs_save_meta( $post_id ) {
		
		if ( !isset( $_POST['wafs_settings_meta_box_nonce'] ) )
			return $post_id;
			
		$nonce = $_POST['wafs_settings_meta_box_nonce'];
		
		if ( ! wp_verify_nonce( $nonce, 'wafs_settings_meta_box' ) )
			return $post_id;
			
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
			
		if ( ! current_user_can( 'manage_woocommerce' ) )
			return $post_id;
		
		$shipping_method = $_POST['_wafs_shipping_method'];

		update_post_meta( $post_id, '_wafs_shipping_method', $shipping_method );
		
	}
	
	
	/**
	 * wafs_save_condition_meta functon.
	 *
	 * Validate and save post meta
	 */
	public function wafs_save_condition_meta( $post_id ) {
		
		if ( !isset( $_POST['wafs_conditions_meta_box_nonce'] ) )
			return $post_id;
			
		$nonce = $_POST['wafs_conditions_meta_box_nonce'];
		
		if ( ! wp_verify_nonce( $nonce, 'wafs_conditions_meta_box' ) )
			return $post_id;
			
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
			
		if ( ! current_user_can( 'manage_woocommerce' ) )
			return $post_id;
		
		$shipping_method_conditions = $_POST['_wafs_shipping_method_conditions'];

		update_post_meta( $post_id, '_wafs_shipping_method_conditions', $shipping_method_conditions );

	}
	
}
$wafs_post_type = new Wafs_Post_Type();

/**
 * Load condition object
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/settings/conditions/class-wafs-condition.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/settings/conditions/child-conditions/class-wafs-child-condition.php';
/**
 * Load ajax methods
 */
require_once plugin_dir_path( __FILE__ ) . '/class-wafs-ajax.php';

?>