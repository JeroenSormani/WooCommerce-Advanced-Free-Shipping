<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_State_Condition' ) ) {

	class WPC_State_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'State', 'wpc-conditions' );
			$this->slug        = __( 'state', 'wpc-conditions' );
			$this->group       = __( 'User', 'wpc-conditions' );
			$this->description = __( 'Compare against the customer state. Note: only installed states will show up', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {
			return WC()->customer->get_shipping_country() . '_' . WC()->customer->get_shipping_state();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {


			$country_states = array();
			foreach ( WC()->countries->states as $country => $states ) {

				if ( empty( $states ) ) continue; // Don't show country if it has no states
				if ( ! array_key_exists( $country, WC()->countries->get_allowed_countries() ) ) continue; // Skip unallowed countries

				foreach ( $states as $state_key => $state ) {
					$country_states[ WC()->countries->countries[ $country ] ][ $country . '_' . $state_key ] = $state;
				}

			}

			$field_args = array(
				'type' => 'select',
				'class' => array( 'wpc-value', 'wc-enhanced-select' ),
				'options' => $country_states,
			);

			return $field_args;

		}

	}

}