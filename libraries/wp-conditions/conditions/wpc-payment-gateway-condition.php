<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Payment_Gateway_Condition' ) ) {

	class WPC_Payment_Gateway_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Payment Gateway', 'wpc-conditions' );
			$this->slug        = __( 'payment_gateway', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Payment gateway can only be checked in the checkout', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {
			return WC()->session->get( 'chosen_payment_method' );
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
			);

			foreach ( WC()->payment_gateways->payment_gateways() as $gateway ) :
				$field_args['options'][ $gateway->id ] = $gateway->get_title();
			endforeach;

			return $field_args;

		}

	}

}