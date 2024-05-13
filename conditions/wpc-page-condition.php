<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Page_Condition' ) ) {

	class WPC_Page_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Page', 'wpc-conditions' );
			$this->slug        = __( 'page', 'wpc-conditions' );
			$this->group       = __( 'General', 'wpc-conditions' );
			$this->description = __( 'Match the given page to the viewing page', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			global $post;

			$value    = $this->get_value( $value );
			$wp_query = $this->get_compare_value();
			$post_id  = isset( $post->ID ) ? $post->ID : null;

			if ( '==' == $operator ) :

				if ( $wp_query->is_archive() && is_array( term_exists( $value, 'product_cat' ) ) ) : // term_exists return array when true
					$match = ( isset( $wp_query->query_vars['product_cat'] ) && $value == $wp_query->query_vars['product_cat'] );
				elseif ( wc_get_page_id( 'shop' ) == $value ) : // Shop page
					$match = is_shop();
				else :
					// #29 - page/single check added to prevent issue with archive pages where $post->ID is set to the first product
					$match = ( ( is_page( $post_id ) || is_single( $post_id ) ) && $post_id == $value );
				endif;

			elseif ( '!=' == $operator ) :

				if ( $wp_query->is_archive() && is_array( term_exists( $value, 'product_cat' ) ) ) : // term_exists return array when true
					$match = ( isset( $wp_query->query_vars['product_cat'] ) && $value != $wp_query->query_vars['product_cat'] );
				elseif ( wc_get_page_id( 'shop' ) == $value ) : // Shop page
					$match = ! is_shop();
				else :
					$match = ( ( is_page( $post_id ) || is_single( $post_id ) ) && $post_id != $value );
				endif;

			endif;

			return $match;

		}

		public function get_compare_value() {
			global $wp_query;
			return $wp_query;
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$wc_pages = array(
				get_option( 'woocommerce_shop_page_id' )      => __( 'Shop page', 'wpc-conditions' ),
				get_option( 'woocommerce_cart_page_id' )      => __( 'Cart', 'wpc-conditions' ),
				get_option( 'woocommerce_checkout_page_id' )  => __( 'Checkout', 'wpc-conditions' ),
				get_option( 'woocommerce_terms_page_id' )     => __( 'Terms & conditions', 'wpc-conditions' ),
				get_option( 'woocommerce_myaccount_page_id' ) => __( 'My account', 'wpc-conditions' ),
			);
			$wc_categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
			$wc_categories = wp_list_pluck( $wc_categories, 'name', 'slug' );

			$wc_products = array();
			$products = get_posts( array( 'posts_per_page' => 9999, 'post_type' => 'product', 'order' => 'asc', 'orderby' => 'title' ) );
			foreach ( $products as $product ) :
				$wc_products[ $product->ID ] = $product->post_title;
			endforeach;

			$field_args = array(
				'type' => 'select',
				'class' => array( 'wpc-value', 'wc-enhanced-select' ),
				'options' => array(
					'WooCommerce pages'  => $wc_pages,
					'Product categories' => $wc_categories,
					'Products' => $wc_products,
				),
			);

			return $field_args;

		}

	}

}
