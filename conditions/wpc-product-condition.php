<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Condition' ) ) {

	class WPC_Product_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product', 'wpc-conditions' );
			$this->slug        = __( 'product', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the current product', 'wpc-conditions' );

			parent::__construct();
		}

		public function validate() {
			return isset( $GLOBALS['product'] );
		}

		public function get_compare_value() {
			/** @var $product WC_Product */
			global $product;
			return $product->get_id();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$field_args = array(
				'type' => 'text',
				'custom_attributes' => array(
					'data-placeholder' => __( 'Search for a product', 'wp-conditions' ),
				),
				'class' => array( 'wpc-value', 'wc-product-search' ),
				'options' => array(),
			);

			// Should be a select field in WC 2.7+
			if ( version_compare( WC()->version, '2.7', '>=' ) ) {
				$field_args['type'] = 'select';
			}

			return $field_args;

		}

	}

}