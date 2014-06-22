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

class Wafs_Ajax {


	/* Construct.
	 *
	 * Add ajax actions in order to work.
	 */
	public function __construct() {
		
		// Add elements
		add_action( 'wp_ajax_wafs_add_condition', array( $this, 'wafs_add_condition' ) );
		add_action( 'wp_ajax_wafs_add_condition_group', array( $this, 'wafs_add_condition_group' ) );
		
		// Update elements
		add_action( 'wp_ajax_wafs_update_condition_value', array( $this, 'wafs_update_condition_value' ) );
		add_action( 'wp_ajax_wafs_update_condition_description', array( $this, 'wafs_update_condition_description' ) );
		
		// Child conditions
		add_action( 'wp_ajax_wafs_add_child_condition', array( $this, 'wafs_add_child_condition' ) );
		add_action( 'wp_ajax_wafs_update_child_condition_value', array( $this, 'wafs_update_child_condition_value' ) );
		add_action( 'wp_ajax_wafs_update_condition_add_child_button', array( $this, 'wafs_update_condition_add_child_button' ) );
		
	}
	
	/* 
	 * Render new condition
	 */
	public function wafs_add_condition() {

		new Wafs_Condition( null, $_POST['group'] );
		die();
		
	}
	
	public function wafs_add_child_condition() {
		
		new Wafs_Child_Condition( $_POST['parent_id'], null, $_POST['group'] );
		die();
	}
	
	/*
	 * Render new condition group.
	 */
	public function wafs_add_condition_group() {
		?>
		<div class='condition-group condition-group-<?php echo $_POST['group']; ?>' data-group='<?php echo $_POST['group']; ?>'>
			
			<p class='or_match'><?php _e( 'Or match all of the following rules to allow free shipping:', 'woocommerce-advanced-free-shipping' );?></p>
			<?php 
			new Wafs_Condition( null, $_POST['group'] ); 
			?>

		</div>

		<p><strong><?php _e( 'Or', 'woocommerce-advanced-free-shipping' ); ?></strong></p>
			
		<?php
		die();
	}

	
	/* Update condition values.
	 *
	 * Retreive and render the new condition values according to the condition key
	 */
	public function wafs_update_condition_value() {

		wafs_condition_values( $_POST['id'], $_POST['group'], $_POST['condition'] );
		die();
		
	}
	
	
	/* Update child condition values.
	 *
	 * Retreive and render the new child condition values according to the condition key
	 */
	public function wafs_update_child_condition_value() {

		$parent_condition = array( 'condition' => $_POST['parent_condition'], 'value' => $_POST['parent_value'] );
		wafs_child_condition_values( $_POST['parent_id'], $_POST['id'], $_POST['group'], $_POST['condition'], '', $parent_condition );
		die();
		
	}
	
	
	/* Update child add button.
	 *
	 * Retreive and render the add buttons for the condition. This may add or delete the 'add child condition' button
	 */
	public function wafs_update_condition_add_child_button() {

		$has_child = array(
			'only_product',
			'contains_product',
		);

		if ( in_array( $_POST['condition'], $has_child ) ) :

			?>
			<a class='button add-child-condition' data-group='<?php echo $this->group; ?>' title='<?php _e( 'Add child condition', 'woocommerce-advanced-free-shipping' ); ?>' href='javascript:void(0);'>+</a><?php		
			
		endif;
		
		die();
		
	}
	
		
	/* Update condition description
	 *
	 * Render the corresponding description for the condition key
	 */
	public function wafs_update_condition_description() {
	
		wafs_condition_description( $_POST['condition'] );
		die();
		
	}
	

}
new Wafs_Ajax();