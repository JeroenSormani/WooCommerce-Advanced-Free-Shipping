<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Category_Condition' ) ) {

	class WPC_Product_Category_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product Category', 'wpc-conditions' );
			$this->slug        = __( 'product_category', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product categories', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function match( $match, $operator, $value ) {

			if ( ! $this->validate() ) {
				return false;
			}

			/** @var $product WC_Product */
			global $product;

			$value = $this->get_value( $value );

			if ( '==' == $operator ) {
				$match = $match = ( has_term( $value, 'product_cat', $product->get_id() ) );
			} elseif ( '!=' == $operator ) {
				$match = ! $match = ( has_term( $value, 'product_cat', $product->get_id() ) );
			}

			return $match;

		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

	}

}