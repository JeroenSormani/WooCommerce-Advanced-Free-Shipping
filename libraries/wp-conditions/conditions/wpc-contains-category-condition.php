<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Contains_Category_Condition' ) ) {

	class WPC_Contains_Category_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Contains Category', 'wpc-conditions' );
			$this->slug        = __( 'contains_category', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Cart must contain at least one product with the selected category', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value = $this->get_term_id( $value );

			if ( '==' == $operator ) :

				foreach ( WC()->cart->get_cart() as $product ) :

					if ( has_term( $value, 'product_cat', $product['product_id'] ) ) :
						return true;
					endif;

				endforeach;

			elseif ( '!=' == $operator ) :

				$match = true;
				foreach ( WC()->cart->get_cart() as $product ) :

					if ( has_term( $value, 'product_cat', $product['product_id'] ) ) :
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

			$categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
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
			$term    = get_term_by( 'slug', $term, 'product_cat' );
			$term_id = $term->term_id ?? null;

			return apply_filters( 'wpml_object_id', $term_id, 'product_category', true );
		}
	}

}
