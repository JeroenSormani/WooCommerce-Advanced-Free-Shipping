<?php
/**
 * Class Wafs_Child_Condition
 *
 * Create a child condition rule
 *
 * @class       Wafs_Child_Condition
 * @author     	Jeroen Sormani
 * @package		WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wafs_Child_Condition {
	
	public $condition;
	public $operator;
	public $value;
	public $group;
	public $id;


	/**
	 * __construct functon.
	 */
	public function __construct( $parent_id, $id = null, $group = 0, $condition = null, $operator = null, $value = null, $parent_condition = null ) {
		 
		 $this->parent_id			= $parent_id;
		 $this->id					= $id;
		 $this->group 				= $group;
		 $this->condition 			= $condition;
		 $this->parent_condition 	= $parent_condition;
		 $this->operator 			= $operator;
		 $this->value 				= $value;
		 
		 if ( ! $id )
		 	$this->id = rand();
		 
		 $this->wafs_create_child_object();
		 
	}
	
	
	/**
	 * Create condition.
	 *
	 * Created a condition rule object
	 */
	public function wafs_create_child_object() {
		
		?><div class='child-condition'>
			<div class='wafs-condition-wrap'><?php
	
				do_action( 'wafs_before_child_condition' );
				
				$this->wafs_child_condition_conditions();
				$this->wafs_child_condition_operator();
				$this->wafs_child_condition_values();
				
				$this->wafs_child_remove_condition_button();
				
				$this->wafs_child_condition_description();
				
				do_action( 'wafs_after_child_condition' );
				
			?></div>
		</div><?php
		
	}	
	
	
	/**
	 * Condition dropdown.
	 *
	 * Render and load condition dropdown
	 */
	public function wafs_child_condition_conditions() {

		wafs_child_condition_conditions( $this->parent_id, $this->id, $this->group, $this->condition, $this->parent_condition );
		
	}
	

	/**
	 * Operator dropdown.
	 *
	 * Render and load operator dropdown
	 */
	public function wafs_child_condition_operator() {
		
		wafs_child_condition_operator( $this->parent_id, $this->id, $this->group, $this->operator );
		
	}
	

	/**
	 * Value dropdown.
	 *
	 * Render and load value dropdown
	 */
	public function wafs_child_condition_values() {

		wafs_child_condition_values( $this->parent_id, $this->id, $this->group, $this->condition, $this->value, $this->parent_condition );
		
	}
	
	public function wafs_add_child_condition_button() {	
	}
	
	public function wafs_child_remove_condition_button() {
		?>
		<a class='button child-condition-delete' href='javascript:void(0);'>-</a>
		<?php
	}
	
	public function wafs_child_condition_description() {
		
		wafs_child_condition_description( $this->condition );
		
	}
	
}
/**
 * Load condition keys dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-child-conditions.php';

/**
 * Load condition operator dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-child-operators.php';

/**
 * Load condition value dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-child-values.php';

/**
 * Load condition descriptions.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-child-descriptions.php';
?>