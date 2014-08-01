<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
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
	 * __construct function.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		 
		 $this->wafs_register_post_type();

		 add_action( 'add_meta_boxes', array( $this, 'wafs_post_type_meta_box' ) );
		 add_action( 'save_post', array( $this, 'wafs_save_meta' ) );
		 add_action( 'save_post', array( $this, 'wafs_save_condition_meta' ) );
		 
 		 // Edit user messages
		 add_filter( 'post_updated_messages', array( $this, 'wafs_custom_post_type_messages' ) );

		 // Redirect after delete
		 add_action('load-edit.php', array( $this, 'wafs_redirect_after_trash' ) );

	 }
	 
	 
	/**
	 * Register post type.
	 *
	 * Register 'wafs' post type.
	 *
	 * @since 1.0.0
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
	 * Edit user messages.
	 *
	 * @since 1.0.0
	 *
	 * @return array User messages.
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
		
		$overview_link = admin_url( 'admin.php?page=wc-settings&tab=shipping&section=wafs_free_shipping_method' );

		$overview = sprintf( ' <a href="%s">%s</a>', esc_url( $overview_link ), __( 'Return to overview.', 'woocommerce-advanced-free-shipping' ) );
		$messages['wafs'][1] .= $overview;
		$messages['wafs'][6] .= $overview;
		$messages['wafs'][9] .= $overview;
		$messages['wafs'][8]  .= $overview;
		$messages['wafs'][10] .= $overview;
		
		return $messages;
		
	}


	/**
	 * Add meta boxes.
	 *
	 * Add two meta boxes to WAFS with conditions and settings.
	 *
	 * @since 1.0.0
	 */
	public function wafs_post_type_meta_box() {
		
		add_meta_box( 'wafs_conditions', __( 'Advanced Free Shipping conditions', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_conditions' ), 'wafs', 'normal' );
		add_meta_box( 'wafs_settings', __( 'Shipping settings', 'woocommerce-advanced-free-shipping' ), array( $this, 'render_wafs_settings' ), 'wafs', 'normal' );
		
	}
	
	
	/**
	 * Render conditions meta box.
	 *
	 * Render and display the condition meta box contents.
	 *
	 * @since 1.0.0
	 */
	public function render_wafs_conditions() {
		
		/**
		 * Load meta box conditions view.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings/meta-box-conditions.php';
		
	}
	
	
	/**
	 * Render settings meta box.
	 *
	 * Render and display the settings meta box conditions.
	 *
	 * @since 1.0.0
	 */
	public function render_wafs_settings() {
		
		/**
		 * Load meta box settings view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings/meta-box-settings.php';
		
	}
		
	
	/**
	 * Save conditions meta box.
	 *
	 * Validate and save post meta from conditions meta box.
	 *
	 * @since 1.0.0
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


	/**
	 * Save settings meta box.
	 *
	 * Validate and save post meta from settings meta box.
	 *
	 * @since 1.0.0
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
	 * Trash redirect.
	 *
	 * Redirect to overview when a method is deleted.
	 *
	 * @since 1.0.0
	 */
	public function wafs_redirect_after_trash() {

		$screen = get_current_screen();

		if( 'edit-wafs' == $screen->id ) :
		
			if( isset( $_GET['trashed'] ) &&  intval( $_GET['trashed'] ) > 0 ) :

				$redirect = admin_url( '/admin.php?page=wc-settings&tab=shipping&section=wafs_free_shipping_method' );
				wp_redirect( $redirect );
				exit();

			endif;
			
		endif;

		
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