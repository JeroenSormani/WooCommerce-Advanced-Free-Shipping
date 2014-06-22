<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_child_condition_values( $parent_id, $id, $group = 0, $condition = 'quantity', $current_value = '', $parent_condition = '' ) {

	global $woocommerce;
	$values = array( 'placeholder' => '', 'min' => '', 'max' => '', 'field' => 'text', 'options' => array() );
	
	switch ( $condition ) :
		
		default:
		case 'quantity' :
		
			$values['field'] = 'number';
		
		break;
		
		case 'variation' :
			
			$product = get_product( $parent_condition['value'] );

			$values['field'] = 'select';
			
			if ( ! $product || 'variable' != $product->product_type ) break;

			foreach ( $product->get_available_variations() as $variation ) :
				
				$variation_title = '';
				foreach ( $variation['attributes'] as $name => $option ) :
					$variation_title .= $option;
				endforeach;
				
				$values['options'][ $variation['variation_id'] ] = $variation_title;

			endforeach;

			
		break;
		
		case 'weight' :
		
			$values['field'] = 'text';
		
		break;
				
		case 'stock' :

			$values['field'] = 'number';

		break;
		
	endswitch;
	
	$values = apply_filters( 'wafs_values', $values, $condition );
	?>
	
	<span class='wafs-child-value-wrap wafs-value-wrap wafs-value-wrap-<?php echo $id; ?>'>
		
		<?php
		switch ( $values['field'] ) :
			
			case 'text' :
				?>
				<input type='text' class='wafs-child-value wafs-value' 
					name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $parent_id; ?>][child_conditions][<?php echo $id; ?>][value]' 
						placeholder='<?php echo $values['placeholder']; ?>' value='<?php echo $current_value; ?>'>
				<?php
			break;
			
			case 'number' : 
				?>
				<input type='text' class='wafs-child-value wafs-value' 
					name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $parent_id; ?>][child_conditions][<?php echo $id; ?>][value]' 
					min='<?php echo $values['min']; ?>' max='<?php echo $values['max']; ?>' placeholder='<?php echo $values['placeholder']; ?>' 
						value='<?php echo $current_value; ?>'>
				<?php
			break;
			
			default :
			case 'select' :
				?><select class='wafs-child-value wafs-value' 
					name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $parent_id; ?>][child_conditions][<?php echo $id; ?>][value]'><?php
					
				foreach ( $values['options'] as $key => $value ) :

					if ( ! is_array( $value ) ) :
						?><option value='<?php echo $key; ?>' <?php selected( $key, $current_value ); ?>><?php echo $value; ?></option><?php
					else :
						?><optgroup label='<?php echo $key ?>'><?php
							foreach ( $value as $k => $v ) :
								?><option value='<?php echo $k; ?>' <?php selected( $k, $current_value ); ?>><?php echo $v; ?></option><?php
							endforeach;
						?></optgroup><?php

					endif;
					
				
				endforeach;
				
				if ( empty( $values['options'] ) ) :
					?><option readonly disabled><?php
						_e( 'No options available', 'woocommerce-advanced-free-shipping' ); 
					?></option><?php
				endif;

				?></select><?php
				
			break;
			
		endswitch;
		
		?>
		
	</span>
	
	<?php
	
}

?>