<?php

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
		
		<select id='' class='wafs-operator' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][operator]'>
			
			<?php
			foreach ( $operators as $key => $value ) :
				$selected = ( $key == $current_value ) ? "SELECTED" : null;
				?>
				<option value='<?php echo $key; ?>' <?php echo $selected; ?>><?php echo $value; ?></option>
				<?php
			endforeach;
			?>
			
		</select>
		
	</span>
	
	<?php
	
}

?>