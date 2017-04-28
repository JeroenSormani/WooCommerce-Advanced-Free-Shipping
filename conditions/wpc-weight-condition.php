<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Weight_Condition' ) ) {

	class WPC_Weight_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Weight', 'wpc-conditions' );
			$this->slug        = __( 'weight', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Weight calculated on all the cart contents', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_value( $value ) {
			return str_replace( ',', '.', $value );
		}

		public function get_compare_value() {
			return WC()->cart->get_cart_contents_weight();
		}

	}

}
