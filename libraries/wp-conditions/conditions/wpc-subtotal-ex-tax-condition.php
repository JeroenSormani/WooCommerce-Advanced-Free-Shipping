<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Subtotal_Ex_Tax_Condition' ) ) {

	class WPC_Subtotal_Ex_Tax_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Subtotal ex. taxes', 'wpc-conditions' );
			$this->slug        = __( 'subtotal_ex_tax', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Compared against the order subtotal excluding taxes', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_value( $value ) {
			return str_replace( ',', '.', $value );
		}

		public function get_compare_value() {
			if ( method_exists( WC()->cart, 'get_subtotal' ) ) { // WC 3.2+
				return WC()->cart->get_subtotal();
			}

			return WC()->cart->subtotal_ex_tax;
		}

	}

}