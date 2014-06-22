<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_condition_operator( $id, $group = 0, $current_value = '==' ) {
	
	$operators = array(
		'==' => __( 'Equal to', 'woocommerce-advanced-free-shipping' ),
		'!=' => __( 'Not equal to', 'woocommerce-advanced-free-shipping' ),
		'>=' => __( 'Greater or equal to', 'woocommerce-advanced-free-shipping' ),
		'<=' => __( 'Less or equal to ', 'woocommerce-advanced-free-shipping' ),
	);
	
	$operators = apply_filters( 'wafs_operators', $operators );
	?>
	
	<span class='wafs-operator-wrap wafs-operator-wrap-<?php echo $id; ?>'>
		
		<select class='wafs-operator' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][operator]'>
			
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