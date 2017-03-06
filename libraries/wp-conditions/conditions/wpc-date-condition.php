<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Date_Condition' ) ) {

	class WPC_Date_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Date', 'wpc-conditions' );
			$this->slug        = __( 'date', 'wpc-conditions' );
			$this->group       = __( 'General', 'wpc-conditions' );
			$this->description = sprintf( __( 'Compares given date to the current date. Current date: %s', 'wpc-conditions' ), date_i18n( get_option( 'date_format' ) ) );

			parent::__construct();
		}

		public function get_value( $value ) {
			return date( 'Y-m-d', strtotime( $value ) ); // Set date in Year-Month-Day format
		}

		public function get_compare_value() {
			return current_time( 'Y-m-d' ); // Today's date in Year-Month-Day format
		}

		public function get_value_field_args() {

			$field_args = array(
				'type' => 'text',
				'class' => array( 'wpc-value' ),
				'placeholder' => 'dd-mm-yyyy or yyyy-mm-dd',
			);

			return $field_args;

		}

	}

}