<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Stock_Status_Condition' ) ) {

	class WPC_Product_Stock_Status_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product Stock Status', 'wpc-conditions' );
			$this->slug        = __( 'product_stock_status', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product stock status', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_value( $value ) {
			$value = ( $value == 'instock' ) ? 1 : $value;
			$value = ( $value == 'outofstock' ) ? 0 : $value;
			return $value;
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->is_in_stock();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$field_args = array(
				'type'    => 'select',
				'options' => array(
					'1' => __( 'In stock', 'woocommerce' ),
					'0' => __( 'Out of stock', 'woocommerce' ),
				),
			);

			return $field_args;

		}

	}

}