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
		'update_post_term_cache' => false,
		'no_found_rows'          => true,
	) );

	$rates_query    = new WP_Query( $query_args );
	$shipping_rates = $rates_query->posts;

	return apply_filters( 'woocommerce_advanced_free_shipping_get_rates', $shipping_rates );

}

/**************************************************************
 * Backwards compatibility for WP Conditions
 *************************************************************/

/**
 * Add the filters required for backwards-compatibility for the matching functionality.
 *
 * @since 1.1.0
 */
function wafs_add_bc_filter_condition_match( $match, $condition, $operator, $value, $args = array() ) {

	if ( ! isset( $args['context'] ) || $args['context'] != 'wafs' ) {
		return $match;
	}

	if ( has_filter( 'wafs_match_condition_' . $condition ) ) {
		$match = apply_filters( 'wafs_match_condition_' . $condition, $match = false, $operator, $value );
	}

	return $match;

}
add_action( 'wp-conditions\condition\match', 'wafs_add_bc_filter_condition_match', 10, 5 );


/**
 * Add condition descriptions of custom conditions.
 *
 * @since 1.1.0
 */
function wafs_add_bc_filter_condition_descriptions( $descriptions ) {
	return apply_filters( 'wafs_descriptions', $descriptions );
}
add_filter( 'wp-conditions\condition_descriptions', 'wafs_add_bc_filter_condition_descriptions' );


/**
 * Add custom field BC.
 *
 * @since 1.1.0
 */
function wafs_add_bc_action_custom_fields( $type, $args ) {

	if ( has_action( 'woocommerce_advanced_fees_condition_value_field_type_' . $type ) ) {
		do_action( 'woocommerce_advanced_fees_condition_value_field_type_' . $args['type'], $args );
	}

}
add_action( 'wp-conditions\html_field_hook', 'wafs_add_bc_action_custom_fields', 10, 2 );
