<?php

function wafs_condition_description( $condition ) {

	global $woocommerce;

	$descriptions = array(
		'state' 			=> __( 'States are only available in the U.S.', 'wafs' ),
		'weight' 			=> __( 'Weight calculated on all the cart contents', 'wafs' ),
		'length' 			=> __( 'Compared to lengthiest product in cart', 'wafs' ),
		'width' 			=> __( 'Compared to widest product in cart', 'wafs' ),
		'height'			=> __( 'Compared to highest product in cart', 'wafs' ),
		'stock_status' 		=> __( 'All products in cart must match stock status', 'wafs' ),
		'backorder' 		=> __( 'All products in cart must match backorder', 'wafs' ),
		'category' 			=> __( 'All products in cart must match category', 'wafs' ),
		'contains_product' 	=> __( 'Cart must contain one of this product', 'wafs' ),
	);
	
	// Display description
	if ( !isset( $descriptions[ $condition ] ) ) :
		return;
	endif;
	?>
	<span class='wafs-description <?php echo $descriptions[ $condition ]; ?>-description'>

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