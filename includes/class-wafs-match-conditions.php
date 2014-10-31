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

		global $woocommerce;

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_subtotal( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->subtotal == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal <= $value );
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_subtotal_ex_tax( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax <= $value );
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_tax( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		$taxes = array_sum( (array) $woocommerce->cart->taxes );

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_quantity( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count <= $value );
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_contains_product( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;

		foreach ( $woocommerce->cart->cart_contents as $product ) :
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_coupon( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :
			$match = ( in_array( $value, $woocommerce->cart->applied_coupons ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $woocommerce->cart->applied_coupons ) );
		endif;

		return $match;

	}


	/**
	 * Weight.
	 *
	 * Match the condition value against the cart weight.
	 *
	 * @since 1.0.0
	 *
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_weight( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight <= $value );
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
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.	 */
	public function wafs_match_condition_contains_shipping_class( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( $operator == '!=' ) :
			// True until proven false
			$match = true;
		endif;

		foreach ( $woocommerce->cart->cart_contents as $product ) :

			$product = get_product( $product['product_id'] );

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_zipcode( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->customer ) ) return;

		if ( '==' == $operator ) :

			if ( preg_match( '/\, ?/', $value ) ) :
				$match = ( in_array( (int) $woocommerce->customer->get_shipping_postcode(), array_map( 'intval', explode( ',', $value ) ) ) );
			else :
				$match = ( (int) $woocommerce->customer->get_shipping_postcode() == (int) $value );
			endif;

		elseif ( '!=' == $operator ) :

			if ( preg_match( '/\, ?/', $value ) ) :
				$match = ( ! in_array( (int) $woocommerce->customer->get_shipping_postcode(), array_map( 'intval', explode( ',', $value ) ) ) );
			else :
				$match = ( (int) $woocommerce->customer->get_shipping_postcode() != (int) $value );
			endif;

		elseif ( '>=' == $operator ) :
			$match = ( (int) $woocommerce->customer->get_shipping_postcode() >= (int) $value );
		elseif ( '<=' == $operator ) :
			$match = ( (int) $woocommerce->customer->get_shipping_postcode() <= (int) $value );
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_city( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->customer ) ) return;

		if ( '==' == $operator ) :
			$match = ( preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_city() ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_city() ) );
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
		True if this condition matches, false if condition doesn't match.	 */
	public function wafs_match_condition_state( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->customer ) ) return;

		$state = $woocommerce->customer->get_shipping_country() . '_' . $woocommerce->customer->get_shipping_state();

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_country( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->customer ) ) return;

		if ( '==' == $operator ) :
			$match = ( preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_country() ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_country() ) );
		endif;

		return $match;

	}


	/**
	 * User role.
	 *
	 * Match the condition value against the users role.
	 *
	 * @since 1.0.0
	 *
	 * @global object $woocommerce WooCommerce object.
	 * @global object $current_user Current user object for capabilities.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_role( $match, $operator, $value ) {

		global $woocommerce, $current_user;

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_width( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;

		foreach ( $woocommerce->cart->cart_contents as $product ) :

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_height( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;

		foreach ( $woocommerce->cart->cart_contents as $product ) :

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_length( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;

		foreach ( $woocommerce->cart->cart_contents as $product ) :

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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_stock( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;

		foreach ( $woocommerce->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_stock ) :
				$stock[] = ( get_post_meta( $product['data']->variation_id, '_stock', true ) );
			else :
				$stock[] = ( get_post_meta( $product['product_id'], '_stock', true ) );
			endif;

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
	 * Match the condition value against all cart products stock statusses.
	 *
	 * @since 1.0.0
	 *
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_stock_status( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :

			$match = true;
			foreach ( $woocommerce->cart->cart_contents as $product ) :
				if ( get_post_meta( $product['product_id'], '_stock_status', true ) != $value )
					$match = false;
			endforeach;

		elseif ( '!=' == $operator ) :

			$match = true;
			foreach ( $woocommerce->cart->cart_contents as $product ) :
				if ( get_post_meta( $product['product_id'], '_stock_status', true ) == $value )
					$match = false;
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
	 * @global object $woocommerce WooCommerce object.
	 *
	 * @param 	bool 	$match		Current match value.
	 * @param 	string 	$operator	Operator selected by the user in the condition row.
	 * @param 	mixed 	$value		Value given by the user in the condition row.
	 * @return 	BOOL 				Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function wafs_match_condition_category( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		$match = true;

		if ( '==' == $operator ) :

			foreach ( $woocommerce->cart->cart_contents as $product ) :

				if ( ! has_term( $value, 'product_cat', $product['product_id'] ) ) :
					$match = false;
				endif;

			endforeach;

		elseif ( '!=' == $operator ) :

			foreach ( $woocommerce->cart->cart_contents as $product ) :

				if ( has_term( $value, 'product_cat', $product['product_id'] ) ) :
					$match = false;
				endif;

			endforeach;

		endif;

		return $match;

	}

}
new Wafs_Match_Conditions();

?>