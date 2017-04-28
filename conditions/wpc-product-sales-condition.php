<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Sales_Condition' ) ) {

	class WPC_Product_Sales_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product sales', 'wpc-conditions' );
			$this->slug        = __( 'product_sales', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the total product sales', 'wpc-conditions' );

			parent::__construct();
		}


		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;

			if ( method_exists( $product, 'get_total_sales' ) ) { // WC 2.7
				return $product->get_total_sales();
			} else { // < WC 2.7
				return get_post_meta( $product->get_id(), 'total_sales', true );
			}
		}

	}

}