<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Width_Condition' ) ) {

	class WPC_Product_Width_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product Width', 'wpc-conditions' );
			$this->slug        = __( 'product_width', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product width', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->get_width();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

	}

}