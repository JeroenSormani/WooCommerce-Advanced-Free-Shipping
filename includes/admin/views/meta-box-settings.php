<?php
/**
 * WAFS meta box settings.
 *
 * Display the shipping settings in the meta box.
 *
 * @author		Jeroen Sormani
 * @package		Advanced Free Shipping for WooCommerce
 * @version		1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_nonce_field( 'wafs_settings_meta_box', 'wafs_settings_meta_box_nonce' );

global $post;
$settings                   = (array) get_post_meta( $post->ID, '_wafs_shipping_method', true );
$settings['shipping_title'] = ! empty( $settings['shipping_title'] ) ? $settings['shipping_title'] : '';

?><div class='wafs wafs_settings wafs_meta_box wafs_settings_meta_box'>

	<p class='wafs-option'>

		<label for='shipping_title'><?php _e( 'Shipping title', 'woocommerce-advanced-free-shipping' ); ?></label>
		<input
			type='text'
			id='shipping_title'
			name='_wafs_shipping_method[shipping_title]'
			value='<?php echo esc_attr( $settings['shipping_title'] ); ?>'
			placeholder='<?php _e( 'e.g. Free Shipping', 'woocommerce-advanced-free-shipping' ); ?>'
		>

	</p>
	<p class='wafs-option' style="margin-top: 35px; margin-bottom: 0;">
		<i><?php echo __( 'Want to setup paid shipping rates with the same kind of conditional framework? Take a look at my <a href="https://aceplugins.com/plugin/advanced-shipping-for-woocommerce/purchase">Advanced Shipping for WooCommerce</a> plugin!', 'woocommerce-advanced-free-shipping' ); ?></i>
	</p>
</div>
