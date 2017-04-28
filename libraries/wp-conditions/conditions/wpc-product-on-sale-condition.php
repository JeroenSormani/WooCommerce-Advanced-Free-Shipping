<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_On_Sale_Condition' ) ) {

	class WPC_Product_On_Sale_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product on sale', 'wpc-conditions' );
			$this->slug        = __( 'product_on_sale', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare if the product in on sale or not', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->is_on_sale();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$field_args = array(
				'type' => 'select',
				'options' => array(
					'1'	=> __( 'Yes', 'woocommerce-advanced-product-labels' ),
					'0'	=> __( 'No', 'woocommerce-advanced-product-labels' ),
				),
			);

			return $field_args;

		}

	}

}