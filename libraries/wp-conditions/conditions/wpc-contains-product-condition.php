<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Contains_Product_Condition' ) ) {

	class WPC_Contains_Product_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Contains product', 'wpc-conditions' );
			$this->slug        = __( 'contains_product', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Check if a product is or is not present in the cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$product_ids = $this->get_compare_value();

			if ( '==' == $operator ) :
				$match = ( in_array( $value, $product_ids ) );
			elseif ( '!=' == $operator ) :
				$match = ( ! in_array( $value, $product_ids ) );
			endif;

			return $match;

		}

		public function get_compare_value() {

			$product_ids = array();
			foreach ( WC()->cart->cart_contents as $product ) :
				$product_ids[] = $product['product_id'];
				if ( isset( $product['variation_id'] ) ) {
					$product_ids[] = $product['variation_id'];
				}
			endforeach;

			return $product_ids;

		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		// @todo
		public function get_value_field_args() {

			$field_args = array(
				'type' => 'text',
				'custom_attributes' => array(
					'data-placeholder' => __( 'Search for a product', 'wp-conditions' ),
				),
				'class' => array( 'wpc-value', 'wc-product-search' ),
				'options' => array(),
			);

			if ( version_compare( WC()->version, '2.7', '>=' ) ) {
				$field_args['type'] = 'select';
			}

			return $field_args;

		}

	}

}