<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Category_Condition' ) ) {

	class WPC_Category_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Category', 'wpc-conditions' );
			$this->slug        = __( 'category', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'All products in cart must match the given category', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value = $this->get_value( $value );
			$match = true;

			if ( '==' == $operator ) :

				foreach ( WC()->cart->get_cart() as $product ) :

					if ( ! has_term( $value, 'product_cat', $product['product_id'] ) ) :
						$match = false;
					endif;

				endforeach;

			elseif ( '!=' == $operator ) :

				foreach ( WC()->cart->get_cart() as $product ) :

					if ( has_term( $value, 'product_cat', $product['product_id'] ) ) :
						$match = false;
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

	}

}