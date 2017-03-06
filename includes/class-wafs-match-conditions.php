<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Class WAFS_Match_Conditions
 *
 * The WAFS Match Conditions class handles the matching rules for Free Shipping
 *
 * @class 		WAFS_Match_Conditions
 * @author		Jeroen Sormani
 * @package		WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */
class WAFS_Match_Conditions {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'wafs_match_condition_zipcode', array( $this, 'wafs_match_condition_zipcode' ), 10, 3 );
	}


	/**
	 * Zipcode.
	 *
	 * Match the condition value against the users shipping zipcode.
	 *
	 * @since 1.0.2; $value may contain single or comma (,) separated zipcodes.
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_zipcode( $match, $operator, $value ) {

		if ( ! isset( WC()->customer ) ) return $match;

		$user_zipcode = WC()->customer->get_shipping_postcode();
		$user_zipcode = preg_replace( '/[^0-9a-zA-Z]/', '', $user_zipcode );

		// Prepare allowed values.
		$zipcodes = (array) preg_split( '/,+ */', $value );

		// Remove all non- letters and numbers
		foreach ( $zipcodes as $key => $zipcode ) :
			$zip              = preg_replace( '/[^0-9a-zA-Z\-\*]/', '', $zipcode );
			$zipcodes[ $key ] = strtoupper( $zip );
		endforeach;

		if ( '==' == $operator ) :

			foreach ( $zipcodes as $zipcode ) :

				// @since 1.0.9 - Wildcard support (*)
				if ( strpos( $zipcode, '*' ) !== false ) :

					$zipcode = str_replace( '*', '', $zipcode );

					$parts = explode( '-', $zipcode );
					if ( count( $parts ) > 1 ) :
						$match = ( $user_zipcode >= min( $parts ) && $user_zipcode <= max( $parts ) );
					else :
						$match = preg_match( '/^' . preg_quote( $zipcode, '/' ) . '/i', $user_zipcode );
					endif;

				else :
					$match = ( (double) $user_zipcode == (double) $zipcode ); // BC when not using asterisk (wildcard)
				endif;

				if ( $match == true ) {
					return true;
				}

			endforeach;

		elseif ( '!=' == $operator ) :

			// True until proven false
			$match = true;

			foreach ( $zipcodes as $zipcode ) :

				// @since 1.0.9 - Wildcard support (*)
				if ( strpos( $zipcode, '*' ) !== false ) :

					$zipcode = str_replace( '*', '', $zipcode );

					$parts = explode( '-', $zipcode );
					if ( count( $parts ) > 1 ) :
						$zipcode_match = ( $user_zipcode >= min( $parts ) && $user_zipcode <= max( $parts ) );
					else :
						$zipcode_match = preg_match( '/^' . preg_quote( $zipcode, '/' ) . '/i', $user_zipcode );
					endif;

					if ( $zipcode_match == true ) :
						return $match = false;
					endif;

				else :
					$zipcode_match = ( (double) $user_zipcode == (double) $zipcode ); // BC when not using asterisk (wildcard)

					if ( $zipcode_match == true ) :
						return $match = false;
					endif;
				endif;

			endforeach;

		elseif ( '>=' == $operator ) :
			$match = ( (double) $user_zipcode >= (double) $value );
		elseif ( '<=' == $operator ) :
			$match = ( (double) $user_zipcode <= (double) $value );
		endif;

		return $match;

	}


}
