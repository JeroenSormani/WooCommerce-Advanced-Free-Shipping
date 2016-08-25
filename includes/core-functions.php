<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get Advanced Free Shipping rates.
 *
 * Get a list of all the Advanced Free shipping rates.
 *
 * @since 1.0.10
 *
 * @param   array  $args  List of arguments to merge with the default args.
 * @return  array         List of 'wafs' posts.
 */
function wafs_get_rates( $args = array() ) {

	$query_args = wp_parse_args( $args, array(
		'post_type'              => 'wafs',
		'post_status'            => 'publish',
		'posts_per_page'         => 1000,
		'orderby'                => 'menu_order',
		'order'                  => 'ASC',
		'update_post_term_cache' => false
	) );

	$rates_query    = new WP_Query( $query_args );
	$shipping_rates = $rates_query->get_posts();

	return apply_filters( 'woocommerce_advanced_free_shipping_get_rates', $shipping_rates );

}
