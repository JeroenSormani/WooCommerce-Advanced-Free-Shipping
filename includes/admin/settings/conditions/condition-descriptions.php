<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Descriptions.
 *
 * Display a description icon + tooltip on hover.
 *
 * @since 1.0.0
 *
 * @param string $condition Condition to show description for.
 */
function wafs_condition_description( $condition ) {

	$descriptions = array(
		'state' 					=> __( 'States must be installed in WC.', 'woocommerce-advanced-free-shipping' ),
		'weight' 					=> __( 'Weight calculated on all the cart contents', 'woocommerce-advanced-free-shipping' ),
		'length' 					=> __( 'Compared to lengthiest product in cart', 'woocommerce-advanced-free-shipping' ),
		'width' 					=> __( 'Compared to widest product in cart', 'woocommerce-advanced-free-shipping' ),
		'height'					=> __( 'Compared to highest product in cart', 'woocommerce-advanced-free-shipping' ),
		'stock_status' 				=> __( 'All products in cart must match stock status', 'woocommerce-advanced-free-shipping' ),
		'category' 					=> __( 'All products in cart must match category', 'woocommerce-advanced-free-shipping' ),
		'contains_product' 			=> __( 'Cart must contain one of this product', 'woocommerce-advanced-free-shipping' ),
		'contains_shipping_class' 	=> __( 'Cart must contain at least one product with the selected shipping class', 'woocommerce-advanced-free-shipping' ),
	);

	$descriptions = apply_filters( 'wafs_descriptions', $descriptions );

	// Display description
	if ( ! isset( $descriptions[ $condition ] ) ) :
		?><span class='wafs-description no-description'></span><?php
		return;
	endif;

	?><span class='wafs-description <?php echo sanitize_html_class( $condition ); ?>-description'>

		<div class='description'>

			<img class='wafs_tip' src='<?php echo WC()->plugin_url(); ?>/assets/images/help.png' height='24' width='24' />

			<div class='wafs_desc'><?php
				echo esc_html( $descriptions[ $condition ] );
			?></div>

		</div>

	</span><?php

}
