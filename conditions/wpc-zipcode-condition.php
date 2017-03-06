<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Zipcode_Condition' ) ) {

	class WPC_Zipcode_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Zipcode', 'wpc-conditions' );
			$this->slug        = __( 'zipcode', 'wpc-conditions' );
			$this->group       = __( 'User', 'wpc-conditions' );
			$this->description = __( 'Compare against customer zipcode. Comma separated list allowed. Use \'*\' for wildcard', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$zipcode = $this->get_compare_value();

			// Prepare the store-owner set value
			$value_zipcodes = array();
			if ( preg_match( '/\, ?/', $value ) ) :

				foreach ( preg_split( '/\, ?/', $value ) as $v ) :
					$value_zipcodes[] = preg_replace( '/[^0-9a-zA-Z\-]/', '', $v );
				endforeach;

			else :
				$value_zipcodes[] = preg_replace( '/[^0-9a-zA-Z\-]/', '', $value );
			endif;

			// Match zipcode
			if ( '==' == $operator ) :

				foreach ( $value_zipcodes as $zip ) :
					if ( $match = preg_match( '/^' . preg_quote( $zip, '/' ) . '/i', $zipcode ) ) :
						break;
					endif;
				endforeach;

			elseif ( '!=' == $operator ) :

				$match = true;
				foreach ( $value_zipcodes as $zip ) :
					if ( $match = ! preg_match( '/^' . preg_quote( $zip, '/' ) . '/i', $zipcode ) ) :
						break;
					endif;
				endforeach;

			elseif ( '>=' == $operator ) :

				foreach ( $value_zipcodes as $zip ) :

					if ( $match = ( $zipcode >= $zip ) ) :
						break;
					endif;
				endforeach;

			elseif ( '<=' == $operator ) :

				foreach ( $value_zipcodes as $zip ) :

					if ( $match = ( $zipcode <= $zip ) ) :
						break;
					endif;
				endforeach;

			endif;

			return $match;

		}

		public function get_compare_value() {
			return preg_replace( '/[^0-9a-zA-Z\-]/', '', WC()->customer->get_shipping_postcode() );
		}

	}

}