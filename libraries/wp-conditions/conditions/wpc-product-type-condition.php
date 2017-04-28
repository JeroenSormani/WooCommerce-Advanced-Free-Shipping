<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Type_Condition' ) ) {

	class WPC_Product_Type_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product type', 'wpc-conditions' );
			$this->slug        = __( 'product', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the current product type', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->get_type();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$field_args['type'] = 'select';

			$product_types = get_terms( 'product_type', array( 'hide_empty' => false ) );
			foreach ( $product_types as $type ) {
				$field_args['options'][ $type->slug ] = $type->name;
			}

			return $field_args;

		}

	}

}