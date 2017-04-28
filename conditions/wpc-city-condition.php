<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_City_Condition' ) ) {

	class WPC_City_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'City', 'wpc-conditions' );
			$this->slug        = __( 'city', 'wpc-conditions' );
			$this->group       = __( 'User', 'wpc-conditions' );
			$this->description = __( 'Compare against customer city. Comma separated list allowed', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value         = $this->get_value( $value );
			$customer_city = $this->get_compare_value();

			if ( '==' == $operator ) :
				$match = ( in_array( $customer_city, preg_split( '/\, ?/', $value ) ) );
			elseif ( '!=' == $operator ) :
				$match = ( ! in_array( $customer_city, preg_split( '/\, ?/', $value ) ) );
			endif;

			return $match;

		}

		public function get_value( $value ) {
			return strtolower( $value );
		}

		public function get_compare_value() {
			return strtolower( WC()->customer->get_shipping_city() );
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

	}

}