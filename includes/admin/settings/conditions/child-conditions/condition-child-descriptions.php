<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wafs_child_condition_description( $condition ) {

	global $woocommerce;

	$descriptions = array(
		'quantity' 			=> __( 'Quantity of product (variation)', 'woocommerce-advanced-free-shipping' ),
		'variation' 		=> __( 'Variation of product', 'woocommerce-advanced-free-shipping' ),
		'weight' 			=> __( 'Weight based on product (<strong>not</strong> variation dependable)', 'woocommerce-advanced-free-shipping' ),
	);
	
	// Display description
	?>
	<span class='wafs-description wafs-child-description <?php echo $condition; ?>-description'>

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