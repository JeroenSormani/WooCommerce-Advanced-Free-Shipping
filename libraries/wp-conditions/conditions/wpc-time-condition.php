<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Time_Condition' ) ) {

	class WPC_Time_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Time', 'wpc-conditions' );
			$this->slug        = __( 'time', 'wpc-conditions' );
			$this->group       = __( 'General', 'wpc-conditions' );
			$this->description = sprintf( __( 'Compares current server time to user given time. Current time: %s', 'woocommerce-advanced-messages' ), date_i18n( get_option( 'time_format' ) ) );

			parent::__construct();
		}

		public function get_value( $value ) {
			return date_i18n( 'H:i', strtotime( $value ) ); // Returns set time in Hour:Minutes
		}

		public function get_compare_value() {
			return current_time( 'H:i' ); // Compares against current time in Hour:Minutes
		}

		public function get_value_field_args() {

			$field_args = array(
				'type' => 'text',
				'class' => array( 'wpc-value' ),
				'placeholder' => sprintf( __( 'Current time is: %s', 'woocommerce-advanced-messages' ), current_time( 'H:i' ) ),
			);

			return $field_args;

		}

	}

}