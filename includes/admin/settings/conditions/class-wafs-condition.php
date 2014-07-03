<?php
/**
 * Class Wafs_Condition
 *
 * Create a condition rule
 *
 * @class       Wafs_Condition
 * @author     	Jeroen Sormani
 * @package		WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */

class Wafs_Condition {
	
	public $condition;
	public $operator;
	public $value;
	public $group;
	public $id;


	/**
	 * __construct functon.
	 */
	public function __construct( $id = null, $group = 0, $condition = null, $operator = null, $value = null ) {
		 
		 $this->id			= $id;
		 $this->group 		= $group;
		 $this->condition 	= $condition;
		 $this->operator 	= $operator;
		 $this->value 		= $value;
		 
		 if ( ! $id )
		 	$this->id = rand();
		 
		 $this->wafs_create_object();
		 
	}
	
	
	/**
	 * Create condition.
	 *
	 * Created a condition rule object
	 */
	public function wafs_create_object() {
		
		?><div class='wafs-condition-wrap'><?php

			do_action( 'wafs_before_condition' );
			
			$this->wafs_condition_conditions();
			$this->wafs_condition_operator();
			$this->wafs_condition_values();
			
			$this->wafs_add_condition_button();
			$this->wafs_remove_condition_button();
			
			$this->wafs_condition_description();
			
			do_action( 'wafs_after_condition' );
			
		?></div><?php
		
	}	
	
	
	/**
	 * Condition dropdown.
	 *
	 * Render and load condition dropdown
	 */
	public function wafs_condition_conditions() {

		wafs_condition_conditions( $this->id, $this->group, $this->condition );
		
	}
	

	/**
	 * Operator dropdown.
	 *
	 * Render and load operator dropdown
	 */
	public function wafs_condition_operator() {
		
		wafs_condition_operator( $this->id, $this->group, $this->operator );
		
	}
	

	/**
	 * Value dropdown.
	 *
	 * Render and load value dropdown
	 */
	public function wafs_condition_values() {

		wafs_condition_values( $this->id, $this->group, $this->condition, $this->value );
		
	}
	
	public function wafs_add_condition_button() {	
		?>
		<a class='button condition-add' data-group='<?php echo $this->group; ?>' href='javascript:void(0);'>+</a>
		<?php
	}
	
	public function wafs_remove_condition_button() {
		?>
		<a class='button condition-delete' href='javascript:void(0);'>-</a>
		<?php
	}
	
	public function wafs_condition_description() {
		
		wafs_condition_description( $this->condition );
		
	}
	
}
/**
 * Load condition keys dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-conditions.php';

/**
 * Load condition operator dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-operators.php';

/**
 * Load condition value dropdown.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-values.php';

/**
 * Load condition descriptions.
 */
require_once plugin_dir_path( __FILE__ ) . 'condition-descriptions.php';


?>