<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_condition_description( $condition ) {

	global $woocommerce;

	$descriptions = array(
		'zipcode' 			=> __( '\'(Not) Equal to\' values can be separated by comma', 'woocommerce-advanced-free-shipping' ),
		'state' 			=> __( 'By default states are only available in the U.S.', 'woocommerce-advanced-free-shipping' ),
		'shipping_class'	=> __( 'One or more products in cart must match', 'woocommerce-advanced-free-shipping' ),
		'weight' 			=> __( 'Weight calculated on all the cart contents', 'woocommerce-advanced-free-shipping' ),
		'length' 			=> __( 'Compared to lengthiest product in cart', 'woocommerce-advanced-free-shipping' ),
		'width' 			=> __( 'Compared to widest product in cart', 'woocommerce-advanced-free-shipping' ),
		'height'			=> __( 'Compared to highest product in cart', 'woocommerce-advanced-free-shipping' ),
		'stock_status' 		=> __( 'All products in cart must match stock status', 'woocommerce-advanced-free-shipping' ),
		'backorder' 		=> __( 'All products in cart must match backorder', 'woocommerce-advanced-free-shipping' ),
		'category' 			=> __( 'All products in cart must match category', 'woocommerce-advanced-free-shipping' ),
		'contains_product' 	=> __( 'Cart must contain one of this product', 'woocommerce-advanced-free-shipping' ),
	);
	
	// Display description
	?>
	<span class='wafs-description <?php echo $condition; ?>-description'>

		<div class='description'>
			
			<?php if ( isset( $descriptions[ $condition ] ) ) : ?>
			
				<img class='wafs_tip' src='<?php echo $woocommerce->plugin_url(); ?>/assets/images/help.png' height='24' width='24' />
	
				<div class='wafs_desc'>
					<?php echo $descriptions[ $condition ]; ?>
				</div>
			
			<?php endif; ?>
			
		</div>
		
	</span>
	<?php

}
?>