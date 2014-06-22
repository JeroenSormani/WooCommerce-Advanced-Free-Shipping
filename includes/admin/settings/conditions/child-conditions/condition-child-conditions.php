<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_child_condition_conditions( $parent_id, $id, $group = 0, $current_value = 'quantity', $parent_condition = array( 'condition' => 'contains_product') ) {

	$conditions = array(
		'contains_product' => array(
			__( 'Product', 'woocommerce-advanced-free-shipping' ) => array(
				'quantity' 			=> __( 'Quantity', 'woocommerce-advanced-free-shipping' ),
				'variation'			=> __( 'Variation', 'woocommerce-advanced-free-shipping' ),
				'weight' 			=> __( 'Weight', 'woocommerce-advanced-free-shipping' ),
				'stock' 			=> __( 'Stock', 'woocommerce-advanced-free-shipping' ),
			),
		),
		'only_product' => array( 
			__( 'Product', 'woocommerce-advanced-free-shipping' ) => array(
				'quantity' 			=> __( 'Quantity', 'woocommerce-advanced-free-shipping' ),
				'variation'			=> __( 'Variation', 'woocommerce-advanced-free-shipping' ),
				'weight' 			=> __( 'Weight', 'woocommerce-advanced-free-shipping' ),
				'stock' 			=> __( 'Stock', 'woocommerce-advanced-free-shipping' ),
			),			
		),
	);
	
	$conditions = apply_filters( 'wafs_child_conditions', $conditions );
	
	if ( ! empty( $parent_condition ) ) :
		$parent_condition = $parent_condition['condition'];
	else :
		$parent_condition = 'contains_product';
	endif;
	?>
	
	<span class='wafs-child-condition-wrap wafs-child-condition-wrap-<?php echo $id; ?>'>
		
		<select class='wafs-child-condition' data-group='<?php echo $group; ?>' data-id='<?php echo $id; ?>' data-parent-id='<?php echo $parent_id; ?>'
			name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $parent_id; ?>][child_conditions][<?php echo $id; ?>][condition]'>
			
			<?php
			if ( isset( $conditions[ $parent_condition ] ) ) :

				foreach ( $conditions[ $parent_condition ] as $option_group => $values ) :

					?><optgroup label='<?php echo $option_group; ?>'><?php

					foreach ( $values as $key => $value ) :

						?><option value='<?php echo $key; ?>' <?php selected( $key, $current_value ); ?>><?php echo $value; ?></option><?php

					endforeach;

					?></optgroup><?php
					
				endforeach;
			
			else :

				?><option readonly disabled><?php
					_e( 'No options available', 'woocommerce-advanced-free-shipping' ); 
				?></option><?php

			endif;
			?>
			
		</select>
		
	</span>
	
	<?php
	
}

?>