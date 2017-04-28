<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Subtotal_Condition' ) ) {

	class WPC_Subtotal_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Subtotal', 'wpc-conditions' );
			$this->slug        = __( 'subtotal', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Compared against the order subtotal', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_value( $value ) {
			return str_replace( ',', '.', $value );
		}

		public function get_compare_value() {
			return WC()->cart->subtotal;
		}

	}

}