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

		add_filter( 'wafs_match_condition_subtotal', array( $this, 'wafs_match_condition_subtotal' ), 10, 3 );
		add_filter( 'wafs_match_condition_subtotal_ex_tax', array( $this, 'wafs_match_condition_subtotal_ex_tax' ), 10, 3 );
		add_filter( 'wafs_match_condition_tax', array( $this, 'wafs_match_condition_tax' ), 10, 3 );
		add_filter( 'wafs_match_condition_quantity', array( $this, 'wafs_match_condition_quantity' ), 10, 3 );
		add_filter( 'wafs_match_condition_contains_product', array( $this, 'wafs_match_condition_contains_product' ), 10, 3 );
		add_filter( 'wafs_match_condition_coupon', array( $this, 'wafs_match_condition_coupon' ), 10, 3 );
		add_filter( 'wafs_match_condition_weight', array( $this, 'wafs_match_condition_weight' ), 10, 3 );
		add_filter( 'wafs_match_condition_contains_shipping_class', array( $this, 'wafs_match_condition_contains_shipping_class' ), 10, 3 );

		add_filter( 'wafs_match_condition_zipcode', array( $this, 'wafs_match_condition_zipcode' ), 10, 3 );
		add_filter( 'wafs_match_condition_city', array( $this, 'wafs_match_condition_city' ), 10, 3 );
		add_filter( 'wafs_match_condition_state', array( $this, 'wafs_match_condition_state' ), 10, 3 );
		add_filter( 'wafs_match_condition_country', array( $this, 'wafs_match_condition_country' ), 10, 3 );
		add_filter( 'wafs_match_condition_role', array( $this, 'wafs_match_condition_role' ), 10, 3 );

		add_filter( 'wafs_match_condition_width', array( $this, 'wafs_match_condition_width' ), 10, 3 );
		add_filter( 'wafs_match_condition_height', array( $this, 'wafs_match_condition_height' ), 10, 3 );
		add_filter( 'wafs_match_condition_length', array( $this, 'wafs_match_condition_length' ), 10, 3 );
		add_filter( 'wafs_match_condition_stock', array( $this, 'wafs_match_condition_stock' ), 10, 3 );
		add_filter( 'wafs_match_condition_stock_status', array( $this, 'wafs_match_condition_stock_status' ), 10, 3 );
		add_filter( 'wafs_match_condition_category', array( $this, 'wafs_match_condition_category' ), 10, 3 );

	}


	/**
	 * Subtotal.
	 *
	 * Match the condition value against the cart subtotal.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_subtotal( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		if ( '==' == $operator ) :
			$match = ( WC()->cart->subtotal == $value );
		elseif ( '!=' == $operator ) :
			$match = ( WC()->cart->subtotal != $value );
		elseif ( '>=' == $operator ) :
			$match = ( WC()->cart->subtotal >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( WC()->cart->subtotal <= $value );
		endif;

		return $match;

	}


	/**
	 * Subtotal excl. taxes.
	 *
	 * Match the condition value against the cart subtotal excl. taxes.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_subtotal_ex_tax( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		if ( '==' == $operator ) :
			$match = ( WC()->cart->subtotal_ex_tax == $value );
		elseif ( '!=' == $operator ) :
			$match = ( WC()->cart->subtotal_ex_tax != $value );
		elseif ( '>=' == $operator ) :
			$match = ( WC()->cart->subtotal_ex_tax >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( WC()->cart->subtotal_ex_tax <= $value );
		endif;

		return $match;

	}


	/**
	 * Taxes.
	 *
	 * Match the condition value against the cart taxes.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_tax( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		$taxes = array_sum( (array) WC()->cart->taxes );

		if ( '==' == $operator ) :
			$match = ( $taxes == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $taxes != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $taxes >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $taxes <= $value );
		endif;

		return $match;

	}


	/**
	 * Quantity.
	 *
	 * Match the condition value against the cart quantity.
	 * This also includes product quantities.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_quantity( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		if ( '==' == $operator ) :
			$match = ( WC()->cart->cart_contents_count == $value );
		elseif ( '!=' == $operator ) :
			$match = ( WC()->cart->cart_contents_count != $value );
		elseif ( '>=' == $operator ) :
			$match = ( WC()->cart->cart_contents_count >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( WC()->cart->cart_contents_count <= $value );
		endif;

		return $match;

	}


	/**
	 * Contains product.
	 *
	 * Matches if the condition value product is in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_contains_product( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) return $match;

		$product_ids = array();
		foreach ( WC()->cart->cart_contents as $product ) :
			$product_ids[] = $product['product_id'];
		endforeach;

		if ( '==' == $operator ) :
			$match = ( in_array( $value, $product_ids ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $product_ids ) );
		endif;

		return $match;

	}


	/**
	 * Coupon.
	 *
	 * Match the condition value against the applied coupons.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_coupon( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		$coupons = array( 'percent' => array(), 'fixed' => array() );
		foreach ( WC()->cart->get_coupons() as $coupon ) {
			$type               = str_replace( '_product', '', $coupon->discount_type );
			$type               = str_replace( '_cart', '', $type );
			$coupons[ $type ][] = $coupon->coupon_amount;
		}

		// Match against coupon percentage
		if ( strpos( $value, '%' ) !== false ) {

			$percentage_value = str_replace( '%', '', $value );
			if ( '==' == $operator ) :
				$match = in_array( $percentage_value, $coupons['percent'] );
			elseif ( '!=' == $operator ) :
				$match = ! in_array( $percentage_value, $coupons['percent'] );
			elseif ( '>=' == $operator ) :
				$match = empty( $coupons['percent'] ) ? $match : ( min( $coupons['percent'] ) >= $percentage_value );
			elseif ( '<=' == $operator ) :
				$match = ! is_array( $coupons['percent'] ) ? false : ( max( $coupons['percent'] ) <= $percentage_value );
			endif;

			// Match against coupon amount
		} elseif( strpos( $value, '$' ) !== false ) {

			$amount_value = str_replace( '$', '', $value );
			if ( '==' == $operator ) :
				$match = in_array( $amount_value, $coupons['fixed'] );
			elseif ( '!=' == $operator ) :
				$match = ! in_array( $amount_value, $coupons['fixed'] );
			elseif ( '>=' == $operator ) :
				$match = empty( $coupons['fixed'] ) ? $match : ( min( $coupons['fixed'] ) >= $amount_value );
			elseif ( '<=' == $operator ) :
				$match = ! is_array( $coupons['fixed'] ) ? $match : ( max( $coupons['fixed'] ) <= $amount_value );
			endif;

			// Match coupon codes
		} else {

			if ( '==' == $operator ) :
				$match = ( in_array( $value, WC()->cart->applied_coupons ) );
			elseif ( '!=' == $operator ) :
				$match = ( ! in_array( $value, WC()->cart->applied_coupons ) );
			endif;

		}

		return $match;

	}


	/**
	 * Weight.
	 *
	 * Match the condition value against the cart weight.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_weight( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		if ( '==' == $operator ) :
			$match = ( WC()->cart->cart_contents_weight == $value );
		elseif ( '!=' == $operator ) :
			$match = ( WC()->cart->cart_contents_weight != $value );
		elseif ( '>=' == $operator ) :
			$match = ( WC()->cart->cart_contents_weight >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( WC()->cart->cart_contents_weight <= $value );
		endif;

		return $match;

	}


	/**
	 * Shipping class.
	 *
	 * Matches if the condition value shipping class is in the cart.
	 *
	 * @since 1.1.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_contains_shipping_class( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		// True until proven false
		if ( $operator == '!=' ) :
			$match = true;
		endif;

		foreach ( WC()->cart->cart_contents as $product ) :

			$id      = ! empty( $product['variation_id'] ) ? $product['variation_id'] : $product['product_id'];
			$product = wc_get_product( $id );

			if ( $operator == '==' ) :
				if ( $product->get_shipping_class() == $value ) :
					return true;
				endif;
			elseif ( $operator == '!=' ) :
				if ( $product->get_shipping_class() == $value ) :
					return false;
				endif;
			endif;

		endforeach;

		return $match;

	}


/******************************************************
 * User conditions
 *****************************************************/


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


	/**
	 * City.
	 *
	 * Match the condition value against the users shipping city.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_city( $match, $operator, $value ) {

		if ( ! isset( WC()->customer ) ) return $match;

		$customer_city = strtolower( WC()->customer->get_shipping_city() );
		$value         = strtolower( $value );

		if ( '==' == $operator ) :

			if ( preg_match( '/\, ?/', $value ) ) :
				$match = ( in_array( $customer_city, preg_split( '/\, ?/', $value ) ) );
			else :
				$match = ( $value == $customer_city );
			endif;

		elseif ( '!=' == $operator ) :

			if ( preg_match( '/\, ?/', $value ) ) :
				$match = ( ! in_array( $customer_city, preg_split( '/\, ?/', $value ) ) );
			else :
				$match = ( $value == $customer_city );
			endif;

		endif;

		return $match;

	}


	/**
	 * State.
	 *
	 * Match the condition value against the users shipping state
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_state( $match, $operator, $value ) {

		if ( ! isset( WC()->customer ) ) return $match;

		$state = WC()->customer->get_shipping_country() . '_' . WC()->customer->get_shipping_state();

		if ( '==' == $operator ) :
			$match = ( $state == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $state != $value );
		endif;

		return $match;

	}


	/**
	 * Country.
	 *
	 * Match the condition value against the users shipping country.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_country( $match, $operator, $value ) {

		if ( ! isset( WC()->customer ) ) :
			return $match;
		endif;

		$user_country = WC()->customer->get_shipping_country();

		if ( method_exists( WC()->countries, 'get_continent_code_for_country' ) ) :
			$user_continent = WC()->countries->get_continent_code_for_country( $user_country );
		endif;

		if ( '==' == $operator ) :
			$match = stripos( $user_country, $value ) === 0;

			// Check for continents if available
			if ( ! $match && isset( $user_continent ) && strpos( $value, 'CO_' ) === 0 ) :
				$match = stripos( $user_continent, str_replace( 'CO_','', $value ) ) === 0;
			endif;
		elseif ( '!=' == $operator ) :
			$match = stripos( $user_country, $value ) === false;

			// Check for continents if available
			if ( ! $match && isset( $user_continent ) && strpos( $value, 'CO_' ) === 0 ) :
				$match = stripos( $user_continent, str_replace( 'CO_','', $value ) ) === false;
			endif;
		endif;

		return $match;

	}


	/**
	 * User role.
	 *
	 * Match the condition value against the users role.
	 *
	 * @since 1.0.0
	 * @global object $current_user Current user object for capabilities.
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_role( $match, $operator, $value ) {

		global $current_user;

		if ( '==' == $operator ) :
			$match = ( array_key_exists( $value, $current_user->caps ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! array_key_exists( $value, $current_user->caps ) );
		endif;

		return $match;

	}


/******************************************************
 * Product conditions
 *****************************************************/


	/**
	 * Width.
	 *
	 * Match the condition value against the widest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_width( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) return $match;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_width ) :
				$width[] = ( get_post_meta( $product['data']->variation_id, '_width', true ) );
			else :
				$width[] = ( get_post_meta( $product['product_id'], '_width', true ) );
			endif;

		endforeach;

		$max_width = max( (array) $width );

		if ( '==' == $operator ) :
			$match = ( $max_width == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_width != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_width >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_width <= $value );
		endif;

		return $match;

	}


	/**
	 * Height.
	 *
	 * Match the condition value against the highest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_height( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) return $match;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_height ) :
				$height[] = ( get_post_meta( $product['data']->variation_id, '_height', true ) );
			else :
				$height[] = ( get_post_meta( $product['product_id'], '_height', true ) );
			endif;

		endforeach;

		$max_height = max( $height );

		if ( '==' == $operator ) :
			$match = ( $max_height == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_height != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_height >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_height <= $value );
		endif;

		return $match;

	}


	/**
	 * Length.
	 *
	 * Match the condition value against the lenghtiest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_length( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) return $match;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_length ) :
				$length[] = ( get_post_meta( $product['data']->variation_id, '_length', true ) );
			else :
				$length[] = ( get_post_meta( $product['product_id'], '_length', true ) );
			endif;

		endforeach;

		$max_length = max( $length );

		if ( '==' == $operator ) :
			$match = ( $max_length == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_length != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_length >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_length <= $value );
		endif;

		return $match;

	}


	/**
	 * Product stock.
	 *
	 * Match the condition value against all cart products stock.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_stock( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) return $match;

		foreach ( WC()->cart->cart_contents as $product ) :

			$product_id = ! empty( $product['variation_id'] ) ? $product['variation_id'] : $product['product_id'];
			$stock[]    = get_post_meta( $product_id, '_stock', true );

		endforeach;

		$min_stock = min( $stock );

		if ( '==' == $operator ) :
			$match = ( $min_stock == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $min_stock != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $min_stock >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $min_stock <= $value );
		endif;

		return $match;

	}


	/**
	 * Stock status.
	 *
	 * Match the condition value against all cart products stock statuses.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_stock_status( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		if ( '==' == $operator ) :

			$match = true;
			foreach ( WC()->cart->cart_contents as $product ) :
				if ( get_post_meta( $product['product_id'], '_stock_status', true ) != $value ) {
					$match = false;
				}
			endforeach;

		elseif ( '!=' == $operator ) :

			$match = true;
			foreach ( WC()->cart->cart_contents as $product ) :
				if ( get_post_meta( $product['product_id'], '_stock_status', true ) == $value ) {
					$match = false;
				}
			endforeach;

		endif;

		return $match;

	}


	/**
	 * Category.
	 *
	 * Match the condition value against all the cart products category.
	 * With this condition, all the products in the cart must have the given class.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool    $match     Current match value.
	 * @param   string  $operator  Operator selected by the user in the condition row.
	 * @param   mixed   $value     Value given by the user in the condition row.
	 * @return  bool               Matching result, true if results match, otherwise false.
	 */
	public function wafs_match_condition_category( $match, $operator, $value ) {

		if ( ! isset( WC()->cart ) ) return $match;

		$match = true;

		if ( '==' == $operator ) :

			foreach ( WC()->cart->cart_contents as $product ) :

				if ( ! has_term( $value, 'product_cat', $product['product_id'] ) ) :
					$match = false;
				endif;

			endforeach;

		elseif ( '!=' == $operator ) :

			foreach ( WC()->cart->cart_contents as $product ) :

				if ( has_term( $value, 'product_cat', $product['product_id'] ) ) :
					$match = false;
				endif;

			endforeach;

		endif;

		return $match;

	}


}
