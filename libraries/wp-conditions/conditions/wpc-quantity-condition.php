<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Quantity_Condition' ) ) {

	class WPC_Quantity_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Quantity', 'wpc-conditions' );
			$this->slug        = __( 'quantity', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Compared against the quantity of items in the cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {
			return WC()->cart->get_cart_contents_count();
		}

		public function get_value_field_args() {

			$field_args = array(
				'type' => 'number',
			);

			return $field_args;

		}

	}

}