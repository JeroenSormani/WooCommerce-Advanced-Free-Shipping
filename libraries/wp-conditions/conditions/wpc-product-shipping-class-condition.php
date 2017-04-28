<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Shipping_Class_Condition' ) ) {

	class WPC_Product_Shipping_Class_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product Shipping Class', 'wpc-conditions' );
			$this->slug        = __( 'product_shipping_class', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product shipping class', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->get_shipping_class();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$shipping_classes = get_terms( 'product_shipping_class', array( 'hide_empty' => false ) );
			$shipping_classes = array_merge(
				array( '-1' => __( 'No shipping class', 'woocommerce' ) ),
				wp_list_pluck( $shipping_classes, 'name', 'slug' )
			);

			$field_args = array(
				'type' => 'select',
				'options' => $shipping_classes,
				'class' => array( 'wpc-value', 'wc-enhanced-select' ),
			);

			return $field_args;

		}

	}

}