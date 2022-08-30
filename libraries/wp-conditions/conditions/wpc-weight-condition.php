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

		public function match( $match, $operator, $value ) {
			$value         = number_format( $this->get_value( $value ), 5 );
			$compare_value = number_format( $this->get_compare_value(), 5 );

			if ( '==' == $operator ) :
				$match = ( $compare_value == $value );
			elseif ( '!=' == $operator ) :
				$match = ( $compare_value != $value );
			elseif ( '>=' == $operator ) :
				$match = ( $compare_value >= $value );
			elseif ( '<=' == $operator ) :
				$match = ( $compare_value <= $value );
			endif;

			return $match;
		}

		public function get_value_field_args() {

			$field_args = array(
				'class' => array( 'input-text', 'wpc-value', 'wc_input_decimal' ),
			);

			return $field_args;

		}
	}

}
