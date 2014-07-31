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
		
	}
	
	/* 
	 * Render new condition
	 */
	public function wafs_add_condition() {

		new Wafs_Condition( null, $_POST['group'] );
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