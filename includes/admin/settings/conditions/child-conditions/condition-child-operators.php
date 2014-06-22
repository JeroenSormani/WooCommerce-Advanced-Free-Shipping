<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_child_condition_operator( $parent_id, $id, $group = 0, $current_value = '==' ) {
	
	$operators = array(
		'==' => __( 'Equal to', 'woocommerce-advanced-free-shipping' ),
		'!=' => __( 'Not equal to', 'woocommerce-advanced-free-shipping' ),
		'>=' => __( 'Greater or equal to', 'woocommerce-advanced-free-shipping' ),
		'<=' => __( 'Less or equal to ', 'woocommerce-advanced-free-shipping' ),
	);
	
	$operators = apply_filters( 'wafs_child_operators', $operators );
	?>
	
	<span class='wafs-operator-wrap wafs-child-operator-wrap wafs-operator-wrap-<?php echo $id; ?>'>
		
		<select class='wafs-operator wafs-child-operator' 
			name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $parent_id; ?>][child_conditions][<?php echo $id; ?>][operator]'>
			
			<?php
			foreach ( $operators as $key => $value ) :

				?><option value='<?php echo $key; ?>' <?php selected( $key, $current_value ); ?>><?php echo $value; ?></option><?php
				
			endforeach;
			?>
			
		</select>
		
	</span>
	
	<?php
	
}

?>