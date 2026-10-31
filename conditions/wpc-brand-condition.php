<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Brand_Condition' ) ) {

	class WPC_Brand_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Brand', 'wpc-conditions' );
			$this->slug        = __( 'brand', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product brands', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_value( $value ) {
			$term = get_term_by( 'slug', $value, 'product_brand' );
			return apply_filters( 'wpml_object_id', $term->term_id ?? null, 'product_brand', true );
		}

		public function match( $match, $operator, $value ) {

			$value = $this->get_term_id( $value );

			if ( '==' == $operator ) :

				foreach ( WC()->cart->get_cart() as $product ) :

					if ( has_term( $value, 'product_brand', $product['product_id'] ) ) :
						return true;
					endif;

				endforeach;

			elseif ( '!=' == $operator ) :

				$match = true;
				foreach ( WC()->cart->get_cart() as $product ) :

					if ( has_term( $value, 'product_brand', $product['product_id'] ) ) :
						return false;
					endif;

				endforeach;

			endif;

			return $match;

		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$categories = get_terms( 'product_brand', array( 'hide_empty' => false ) );
			$field_args = array(
				'type' => 'select',
				'class' => array( 'wpc-value', 'wc-enhanced-select' ),
				'options' => wp_list_pluck( $categories, 'name', 'slug' ),
			);

			return $field_args;

		}

		/**
		 * Convert slug to ID.
		 *
		 * Convert the category slug to ID and go through WPML translation filter.
		 *
		 * @since NEWVERSION
		 *
		 * @param $term
		 * @return mixed|null
		 */
		private function get_term_id( $term ) {
			$term    = get_term_by( 'slug', $term, 'product_brand' );
			$term_id = $term->term_id ?? null;

			return apply_filters( 'wpml_object_id', $term_id, 'product_brand', true );
		}

	}

}
