<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Fallback_Condition' ) ) {


	/**
	 * Fallback condition is used when wpc_get_condition() is used for a
	 * invalid (unknown) condition class. This ensures nothing breaks and
	 * the initial $match value is returned > ready to be handled by the filter hook.
	 */
	class WPC_Fallback_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( '', 'wpc-conditions' );
			$this->slug        = __( '', 'wpc-conditions' );
			$this->description = __( '', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {
			return $match;
		}

	}

}