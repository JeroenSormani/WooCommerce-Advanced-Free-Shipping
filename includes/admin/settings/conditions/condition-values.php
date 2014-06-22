<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_condition_values( $id, $group = 0, $condition = 'subtotal', $current_value = '' ) {

	global $woocommerce;
	$values = array( 'placeholder' => '', 'min' => '', 'max' => '', 'field' => 'text', 'options' => array() );
	
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
				$values['options'][$product->ID ] = $product->post_title;
			endforeach;
			
		break;
		
		case 'only_product' :
			
			$values['field'] = 'select';

			$products = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'product', 'order' => 'asc', 'orderby' => 'title' ) );
			foreach ( $products as $product ) :
				$values['options'][$product->ID ] = $product->post_title;
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
				
			foreach ( $woocommerce->countries->states as $country => $states ) :
			
				if ( empty( $states ) ) continue; // Don't show country if it has no states
				if ( ! array_key_exists( $country, $woocommerce->countries->get_allowed_countries() ) ) continue; // Skip unallowed countries 
				
				foreach ( $states as $state_key => $state ) :
					$country_states[ $woocommerce->countries->countries[ $country ] ][ $country . '_' . $state_key ] = $state;
				endforeach;

				$values['options'] = $country_states;
				
			endforeach;


			
		break;

		case 'country' :

			$values['field'] = 'select';
			$values['options'] = $woocommerce->countries->get_allowed_countries();
			
		break;
		
		case 'role' :
		
			$values['field'] = 'select';
			$roles = array_keys( get_editable_roles() );
			$values['options'] = array_combine( $roles, $roles );
			
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
			$values['options'] = array(
				'instock' 		=> __( 'In stock', 'woocommerce' ),
				'outofstock'	=> __( 'Out of stock', 'woocommerce' ),
			);
			
		break;
		
		case 'backorder' : 
			
			$values['field'] = 'select';
			$values['options'] = array(
				'no' 		=> __( 'Do not allow', 'woocommerce' ),
				'notify' 	=> __( 'Allow, but notify customer', 'woocommerce' ),
				'yes' 		=> __( 'Allow', 'woocommerce' )
			);
			
		break;

		case 'category' :
		
			$values['field'] = 'select';
			
			$categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
			foreach ( $categories as $category ) :
				$values['options'][ $category->slug ] = $category->name;
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
					placeholder='<?php echo $values['placeholder']; ?>' value='<?php echo $current_value; ?>'>
				<?php
			break;
			
			case 'number' : 
				?>
				<input type='text' class='wafs-value' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][value]' 
					min='<?php echo $values['min']; ?>' max='<?php echo $values['max']; ?>' placeholder='<?php echo $values['placeholder']; ?>' 
					value='<?php echo $current_value; ?>'>
				<?php
			break;
			
			default :
			case 'select' :
				?><select class='wafs-value' name='_wafs_shipping_method_conditions[<?php echo $group; ?>][<?php echo $id; ?>][value]'><?php
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