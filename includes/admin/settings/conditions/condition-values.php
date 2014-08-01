<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Create value input.
 *
 * Set all value and create an input field for it.
 *
 * @since 1.0.0
 *
 * @global object $woocommerce WooCommerce object.
 *
 * @param int id Throw in the condition ID.
 * @param int $group Condition group ID.
 * @param string $condition Condition where the value input is used for.
 * @param string $current_value Current chosen slug.
 */
function wafs_condition_values( $id, $group = 0, $condition = 'subtotal', $current_value = '' ) {

	global $woocommerce;

	switch ( $condition ) :
		
		default:
		case 'subtotal' :
			
			$values['field'] = 'number';
			
		break;
		
		case 'subtotal_ex_tax' :
			
			$values['field'] = 'number';
			
		break;

		case 'tax' :
			
			$values['field'] = 'number';
			
		break;
	
		case 'quantity' :
			
			$values['field'] = 'number';
			
		break;
		
		case 'contains_product' :
			
			$values['field'] = 'select';

			$products = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'product', 'order' => 'asc', 'orderby' => 'title' ) );
			foreach ( $products as $product ) :
				$values['values'][$product->ID ] = $product->post_title;
			endforeach;
			
		break;
		
		case 'coupon' :
			
			$values['field'] = 'text';
			
		break;

		/**
		 * User details
		 */
		 
		case 'zipcode' :
			
			$values['field'] = 'text';
			
		break;

		case 'city' :
			
			$values['field'] = 'text';
			
		break;
		
		case 'state' :
			
			$values['field'] = 'select';
			$values['values'] = $woocommerce->countries->get_states( 'US' );
			
		break;

		case 'country' :

			$values['field'] = 'select';
			$values['values'] = $woocommerce->countries->get_allowed_countries();
			
		break;
		
		case 'role' :
		
			$values['field'] = 'select';
			$roles = array_keys( get_editable_roles() );
			$values['values'] = array_combine( $roles, $roles );
			
		break;
		
		/**
		 * Product
		 */
		 
		case 'width' :
		
			$values['field'] = 'text';
		
		break;

		 
		case 'height' :
		
			$values['field'] = 'text';
		
		break;

		 
		case 'length' :
		
			$values['field'] = 'text';
		
		break;
		
		case 'weight' : 
			
			$values['field'] = 'text';
			
		break;

		case 'stock' :
		
			$values['field'] = 'text';
		
		break;
		
		case 'stock_status' : 
			
			$values['field'] = 'select';
			$values['values'] = array(
				'instock' 		=> __( 'In stock', 'woocommerce-advanced-free-shipping' ),
				'outofstock'	=> __( 'Out of stock', 'woocommerce-advanced-free-shipping' ),
			);
			
		break;

		case 'category' :
		
			$values['field'] = 'select';
			
			$categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
			foreach ( $categories as $category ) :
				$values['values'][ $category->slug ] = $category->name;
			endforeach;
		
		break;

		
	endswitch;

	$values = apply_filters( 'wafs_values', $values, $condition );
	?>
	
	<span class='wafs-value-wrap wafs-value-wrap-<?php echo $id; ?>'>
		
		<?php
		switch ( $values['field'] ) :
			
			case 'text' :
				?>
				<input type='text' class='wafs-value' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][value]' 
					placeholder='<?php echo @$values['placeholder']; ?>' value='<?php echo $current_value; ?>'>
				<?php
			break;
			
			case 'number' : 
				?>
				<input type='text' class='wafs-value' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][value]' 
					min='<?php echo @$values['min']; ?>' max='<?php echo @$values['max']; ?>' placeholder='<?php echo @$values['placeholder']; ?>' 
					value='<?php echo $current_value; ?>'>
				<?php
			break;
			
			default :
			case 'select' :
				?><select class='wafs-value' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][value]'>
				<option <?php selected( '', $current_value ); ?>><?php _e( 'Select option' , 'woocommerce-advanced-free-shipping' ); ?></option><?php
				foreach ( $values['values'] as $key => $value ) :

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
				
				
				if ( empty( $values['values'] ) ) :
					?><option readonly disabled><?php
						_e( 'There are no options available', 'woocommerce-advanced-free-shipping' ); 
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