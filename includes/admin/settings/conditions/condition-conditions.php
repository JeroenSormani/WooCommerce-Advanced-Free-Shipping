<?php

function wafs_condition_conditions( $id, $group = 0, $current_value = 'total' ) {

	$conditions = array(
		__( 'Cart', 'woocommerce-advanced-free-shipping' ) => array( 
			'subtotal' 			=> __( 'Subtotal', 'woocommerce-advanced-free-shipping' ),
			'subtotal_ex_tax' 	=> __( 'Subtotal ex. taxes', 'woocommerce-advanced-free-shipping' ),
			'tax' 				=> __( 'Tax', 'woocommerce-advanced-free-shipping' ),
			'quantity' 			=> __( 'Quantity', 'woocommerce-advanced-free-shipping' ),
			'contains_product' 	=> __( 'Contains product', 'woocommerce-advanced-free-shipping' ),
			'coupon' 			=> __( 'Coupon', 'woocommerce-advanced-free-shipping' ),
		),
		__( 'User Details', 'woocommerce-advanced-free-shipping' ) => array(
			'zipcode' 			=> __( 'Zipcode', 'woocommerce-advanced-free-shipping' ),
			'city' 				=> __( 'City', 'woocommerce-advanced-free-shipping' ),
			'state'	 			=> __( 'State', 'woocommerce-advanced-free-shipping' ),
			'country' 			=> __( 'Country', 'woocommerce-advanced-free-shipping' ),
			'role'	 			=> __( 'User role', 'woocommerce-advanced-free-shipping' ),
		),
		__( 'Product', 'woocommerce-advanced-free-shipping' ) => array(
			'width' 			=> __( 'Width', 'woocommerce-advanced-free-shipping' ),
			'height' 			=> __( 'Height', 'woocommerce-advanced-free-shipping' ),
			'length' 			=> __( 'Length', 'woocommerce-advanced-free-shipping' ),
			'weight' 			=> __( 'Weight', 'woocommerce-advanced-free-shipping' ),
			'stock' 			=> __( 'Stock', 'woocommerce-advanced-free-shipping' ),
			'stock_status'		=> __( 'Stock status', 'woocommerce-advanced-free-shipping' ),
			'category' 			=> __( 'Category', 'woocommerce-advanced-free-shipping' ),
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