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
class Wafs_post_type {
	
	
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
		 
	 }
	 
	 
	/**
	 * __construct functon.
	 *
	 * 
	 */
	public function wafs_register_post_type() {
		
		$labels = array(
		    'name' 					=> __( 'Advanced Free Shipping methods', 'wapl' ),
			'singular_name' 		=> __( 'Advanced Free Shipping method', 'wapl' ),
		    'add_new' 				=> __( 'Add New', 'wapl' ),
		    'add_new_item' 			=> __( 'Add New Advanced Free Shipping method' , 'wapl' ),
		    'edit_item' 			=> __( 'Edit Advanced Free Shipping method' , 'wapl' ),
		    'new_item' 				=> __( 'New Advanced Free Shipping method' , 'wapl' ),
		    'view_item' 			=> __( 'View Advanced Free Shipping method', 'wapl' ),
		    'search_items' 			=> __( 'Search Advanced Free Shipping methods', 'wapl' ),
		    'not_found' 			=> __( 'No Advanced Free Shipping methods', 'wapl' ),
		    'not_found_in_trash'	=> __( 'No Advanced Free Shipping methods found in Trash', 'wapl' ),
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
	 * wafs_post_type_meta_box functon.
	 *
	 * 
	 */
	public function wafs_post_type_meta_box() {
		
		add_meta_box( 'wafs_conditions', __( 'Advanced Free Shipping conditions', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_conditions' ), 'wafs', 'normal' );
		add_meta_box( 'wafs_settings', __( 'Shipping settings', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_settings' ), 'wafs', 'normal' );
		
	}
	
	
	/**
	 * wafs_conditions_callback functon.
	 *
	 * 
	 */
	public function render_wafs_conditions() {
		
		/**
		 * Load meta box conditions view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings/meta-box-conditions.php';
		
	}
	
	
	/**
	 * wafs_settings_callback functon.
	 *
	 * 
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
$wafs_post_type = new Wafs_post_type();

/**
 * Load condition object
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/settings/conditions/class-wafs-condition.php';
/**
 * Load ajax methods
 */
require_once plugin_dir_path( __FILE__ ) . '/class-wafs-ajax.php';

?>