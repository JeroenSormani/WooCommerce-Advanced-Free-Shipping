<?php

function wafs_condition_conditions( $id, $group = 0, $current_value = 'total' ) {

	$conditions = array(
		__( 'Cart', 'wafs' ) => array( 
			'subtotal' 			=> __( 'Subtotal', 'wafs' ),
			'subtotal_ex_tax' 	=> __( 'Subtotal ex. taxes', 'wafs' ),
			'tax' 				=> __( 'Tax', 'wafs' ),
			'quantity' 			=> __( 'Quantity', 'wafs' ),
			'contains_product' 	=> __( 'Contains product', 'wafs' ),
			'coupon' 			=> __( 'Coupon', 'wafs' ),
		),
		__( 'User Details', 'wafs' ) => array(
			'zipcode' 			=> __( 'Zipcode', 'wafs' ),
			'city' 				=> __( 'City', 'wafs' ),
			'state'	 			=> __( 'State', 'wafs' ),
			'country' 			=> __( 'Country', 'wafs' ),
			'role'	 			=> __( 'User role', 'wafs' ),
		),
		__( 'Product', 'wafs' ) => array(
			'width' 			=> __( 'Width', 'wafs' ),
			'height' 			=> __( 'Height', 'wafs' ),
			'length' 			=> __( 'Length', 'wafs' ),
			'weight' 			=> __( 'Weight', 'wafs' ),
			'stock' 			=> __( 'Stock', 'wafs' ),
			'stock_status'		=> __( 'Stock status', 'wafs' ),
			'category' 			=> __( 'Category', 'wafs' ),
		),
	);
	
	$conditions = apply_filters( 'wafs_conditions', $conditions );
	
	?>
	
	<span class='wafs-condition-wrap wafs-condition-wrap-<?php echo $id; ?>'>
		
		<select class='wafs-condition' data-group='<?php echo $group; ?>' data-id='<?php echo $id; ?>' 
			name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][condition]'>
			
			<?php echo $selected;
			foreach ( $conditions as $option_group => $values ) :
			
				?><optgroup label='<?php echo $option_group; ?>'><?php
				
				foreach ( $values as $key => $value ) :
				
					$selected = ( $key == $current_value ) ? "SELECTED" : null;
					
					?><option value='<?php echo $key; ?>' <?php echo $selected; ?>><?php echo $value; ?></option><?php
				
				endforeach;
				
				?></optgroup><?php
				
			endforeach;
			?>
			
		</select>
		
	</span>
	
	<?php
	
}

?>