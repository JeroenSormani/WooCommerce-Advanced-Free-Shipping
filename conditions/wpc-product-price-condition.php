<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Price_Condition' ) ) {

	class WPC_Product_Price_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product Price', 'wpc-conditions' );
			$this->slug        = __( 'product_price', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product price', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->get_price();
		}

	}

}