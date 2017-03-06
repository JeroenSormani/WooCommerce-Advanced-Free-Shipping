<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Day_Condition' ) ) {

	class WPC_Day_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Day', 'wpc-conditions' );
			$this->slug        = __( 'day', 'wpc-conditions' );
			$this->group       = __( 'General', 'wpc-conditions' );
			$this->description = sprintf( __( 'Compare to day. You can use ranges with greater/less operators. Current day: %s', 'wpc-conditions' ), date_i18n( 'l' ) );

			parent::__construct();
		}

		public function get_compare_value() {
			return current_time( 'N' ); // Returns current day
		}

		public function get_value_field_args() {

			$days[1] = 'Monday';
			$days[2] = 'Tuesday';
			$days[3] = 'Wednesday';
			$days[4] = 'Thursday';
			$days[5] = 'Friday';
			$days[6] = 'Saturday';
			$days[7] = 'Sunday';

			$field_args = array(
				'type' => 'select',
				'class' => array( 'wpc-value' ),
				'options' => $days,
			);

			return $field_args;

		}

	}

}