<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin-functions.php';
}

require_once 'conditions/wpc-condition.php';
require_once 'conditions/wpc-fallback-condition.php';

// General
require_once 'conditions/wpc-page-condition.php';
require_once 'conditions/wpc-day-condition.php';
require_once 'conditions/wpc-date-condition.php';
require_once 'conditions/wpc-time-condition.php';

require_once 'conditions/wpc-subtotal-condition.php';
require_once 'conditions/wpc-subtotal-ex-tax-condition.php';
require_once 'conditions/wpc-tax-condition.php';
require_once 'conditions/wpc-quantity-condition.php';
require_once 'conditions/wpc-contains-product-condition.php';
require_once 'conditions/wpc-coupon-condition.php';
require_once 'conditions/wpc-weight-condition.php';
require_once 'conditions/wpc-contains-shipping-class-condition.php';
require_once 'conditions/wpc-contains-category-condition.php';
require_once 'conditions/wpc-shipping-method-condition.php';
require_once 'conditions/wpc-payment-gateway-condition.php';

require_once 'conditions/wpc-zipcode-condition.php';
require_once 'conditions/wpc-city-condition.php';
require_once 'conditions/wpc-state-condition.php';
require_once 'conditions/wpc-country-condition.php';
require_once 'conditions/wpc-role-condition.php';

// Product (cart based)
require_once 'conditions/wpc-length-condition.php';
require_once 'conditions/wpc-width-condition.php';
require_once 'conditions/wpc-height-condition.php';
require_once 'conditions/wpc-stock-status-condition.php';
require_once 'conditions/wpc-stock-condition.php';
require_once 'conditions/wpc-category-condition.php';
require_once 'conditions/wpc-volume-condition.php';

// Product (single based)
require_once 'conditions/wpc-product-condition.php';
require_once 'conditions/wpc-product-age-condition.php';
require_once 'conditions/wpc-product-type-condition.php';
require_once 'conditions/wpc-product-category-condition.php';
require_once 'conditions/wpc-product-shipping-class-condition.php';
require_once 'conditions/wpc-product-tag-condition.php';
require_once 'conditions/wpc-product-height-condition.php';
require_once 'conditions/wpc-product-length-condition.php';
require_once 'conditions/wpc-product-price-condition.php';
require_once 'conditions/wpc-product-sale-price-condition.php';
require_once 'conditions/wpc-product-stock-condition.php';
require_once 'conditions/wpc-product-stock-status-condition.php';
require_once 'conditions/wpc-product-width-condition.php';
require_once 'conditions/wpc-product-sales-condition.php';
require_once 'conditions/wpc-product-on-sale-condition.php';

if ( ! function_exists( 'wpc_get_registered_conditions' ) ) {

	/**
	 *
	 * @return WPC_Condition[] List of condition classes
	 */
	function wpc_get_registered_conditions() {

		$conditions = array(
			new WPC_Page_Condition(),
			new WPC_Day_Condition(),
			new WPC_Date_Condition(),
			new WPC_Time_Condition(),

			new WPC_Subtotal_Condition(),
			new WPC_Subtotal_Ex_Tax_Condition(),
			new WPC_Tax_Condition(),
			new WPC_Quantity_Condition(),
			new WPC_Contains_Product_Condition(),
			new WPC_Coupon_Condition(),
			new WPC_Weight_Condition(),
			new WPC_Contains_Shipping_Class_Condition(),
			new WPC_Contains_Category_Condition(),
			new WPC_Shipping_Method_Condition(),
			new WPC_Payment_Gateway_Condition(),

			new WPC_Zipcode_Condition(),
			new WPC_City_Condition(),
			new WPC_State_Condition(),
			new WPC_Country_Condition(),
			new WPC_Role_Condition(),

			new WPC_Length_Condition(),
			new WPC_Width_Condition(),
			new WPC_Height_Condition(),
			new WPC_Stock_Status_Condition(),
			new WPC_Stock_Condition(),
			new WPC_Category_Condition(),
			new WPC_Volume_Condition(),

			new WPC_Product_Condition(),
			new WPC_Product_Age_Condition(),
			new WPC_Product_Type_Condition(),
			new WPC_Product_Length_Condition(),
			new WPC_Product_Width_Condition(),
			new WPC_Product_Height_Condition(),
			new WPC_Product_Stock_Status_Condition(),
			new WPC_Product_Stock_Condition(),
			new WPC_Product_Category_Condition(),
			new WPC_Product_Shipping_Class_Condition(),
			new WPC_Product_Tag_Condition(),
			new WPC_Product_Price_Condition(),
			new WPC_Product_Sale_Price_Condition(),
			new WPC_Product_Sales_Condition(),
			new WPC_Product_On_Sale_Condition(),
		);

		return apply_filters( 'wp-conditions\registered_conditions', $conditions );

	}

}


if ( ! function_exists( 'wpc_get_condition' ) ) {

	/**
	 * Get condition instance.
	 *
	 * Get a instance of a WPC_Condition class.
	 *
	 * @since 1.0.0
	 *
	 * @param string $condition Name of the condition to get.
	 * @return WPC_Condition|bool WPC_Condition instance when class exists, false otherwise.
	 */
	function wpc_get_condition( $condition ) {

		$class_name = 'WPC_' . implode( '_', array_map( 'ucfirst', explode( '_', $condition ) ) ) . '_Condition';
		$class_name = apply_filters( 'wpc_get_condition_class_name', $class_name, $condition );

		if ( class_exists( $class_name ) ) {
			return new $class_name();
		} else {
			return new WPC_Fallback_Condition();
		}

	}

}


if ( ! function_exists( 'wpc_match_conditions' ) ) {

	/**
	 * Match conditions.
	 *
	 * Check if conditions match, if all conditions in one condition group
	 * matches it will return TRUE and the fee will be applied.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $condition_groups List of condition groups containing their conditions.
	 * @param array $args Arguments to pass to the matching method.
	 * @return BOOL TRUE if all the conditions in one of the condition groups matches true.
	 */
	function wpc_match_conditions( $condition_groups = array(), $args = array() ) {

		if ( empty( $condition_groups ) || ! is_array( $condition_groups ) ) :
			return false;
		endif;

		foreach ( $condition_groups as $condition_group => $conditions ) :

			$match_condition_group = true;

			foreach ( $conditions as $condition ) :

				$condition     = apply_filters( 'wp-conditions\condition', $condition ); // BC helper
				$wpc_condition = wpc_get_condition( $condition['condition'] );

				// Match the condition - pass any custom ($)args as parameters.
				$match = call_user_func_array( array( $wpc_condition, 'match' ), array( false, $condition['operator'], $condition['value'], $args ) );

				// Filter the matched result - BC helper
				$parameters = array( 'wp-conditions\condition\match', $match, $condition['condition'], $condition['operator'], $condition['value'], $args );
				$match = call_user_func_array( 'apply_filters', $parameters );

				// Original - simple - way
//				$match         = $wpc_condition->match( false, $condition['operator'], $condition['value'] );
//				$match         = apply_filters( 'wp-conditions\condition\match', $match, $condition['condition'], $condition['operator'], $condition['value'] );

				if ( false == $match ) :
					$match_condition_group = false;
				endif;

			endforeach;

			// return true if one condition group matches
			if ( true == $match_condition_group ) :
				return true;
			endif;

		endforeach;

		return false;

	}

}


if ( ! function_exists( 'wpc_sanitize_conditions' ) ) {

	/**
	 * Sanitize conditions.
	 *
	 * Go over all the conditions and sanitize them. Used when the conditions are being saved.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $conditions The list of conditions.
	 * @return array
	 */
	function wpc_sanitize_conditions( $conditions ) {

		$sanitized_conditions = array();
		foreach ( $conditions as $group_key => $condition_group ) :
			if ( $group_key == '9999' ) continue; // Template group

			foreach ( $condition_group as $condition_id => $condition_values ) :
				if ( $condition_id == '9999' ) continue; // Template condition
				if ( ! isset( $condition_values['value'] ) ) $condition_values['value'] = '';

				foreach ( $condition_values as $condition_key => $condition_value ) :

					switch ( $condition_key ) :

						default :
							$condition_value = sanitize_text_field( $condition_value );
							break;

						case 'condition' :
							$condition_value = sanitize_key( $condition_value );
							break;

						case 'operator' :
							$condition_value = in_array( $condition_value, array( '==', '!=', '>=', '<=' ) ) ? $condition_value : '==';
							break;

						case 'value' :
							if ( is_array( $condition_value ) ) :
								$condition_value = array_map( 'sanitize_text_field', $condition_value );
							elseif ( is_string( $condition_value ) ) :
								$condition_value = sanitize_text_field( $condition_value );
							endif;
							break;

					endswitch;

					$sanitized_conditions[ $group_key ][ $condition_id ][ $condition_key ] = $condition_value;

				endforeach;

			endforeach;

		endforeach;

		return $sanitized_conditions;

	}

}


if ( ! function_exists( 'wpc_condition_operators' ) ) {

	/**
	 * Get all condition operators.
	 *
	 * Get a list of the available operators for all the conditions.
	 * Mainly used to determine which operators to show per condition.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of condition operators.
	 */
	function wpc_condition_operators() {

		$condition_operators = array(
			// Add default for when a custom condition doesn't properly add the available operators
			'default' => array(
				'==' => __( 'Equal to', 'wpc-conditions' ),
				'!=' => __( 'Not equal to', 'wpc-conditions' ),
				'>=' => __( 'Greater or equal to', 'wpc-conditions' ),
				'<=' => __( 'Less or equal to ', 'wpc-conditions' ),
			),
		);

		foreach ( wpc_get_registered_conditions() as $condition ) {
			$condition_operators[ $condition->get_slug() ] = $condition->get_available_operators();
		}

		return apply_filters( 'wp-conditions\condition_operators', $condition_operators );

	}

}

if ( ! function_exists( 'wpc_condition_descriptions' ) ) {

	/**
	 * Get all condition operators.
	 *
	 * Get a list of the available operators for all the conditions.
	 * Mainly used to determine which operators to show per condition.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of condition operators.
	 */
	function wpc_condition_descriptions() {

		$condition_descriptions = array();

		foreach ( wpc_get_registered_conditions() as $condition ) {
			$condition_descriptions[ $condition->get_slug() ] = $condition->get_description();
		}

		return apply_filters( 'wp-conditions\condition_descriptions', $condition_descriptions );

	}

}