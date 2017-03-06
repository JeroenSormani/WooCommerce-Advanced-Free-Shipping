<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Tax_Condition' ) ) {

	class WPC_Tax_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Tax', 'wpc-conditions' );
			$this->slug        = __( 'tax', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Compared against the tax total amount', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_value( $value ) {
			return str_replace( ',', '.', $value );
		}

		public function get_compare_value() {
			return array_sum( (array) WC()->cart->taxes );
		}

	}

}