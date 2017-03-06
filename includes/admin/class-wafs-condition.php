<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Condition class.
 *
 * Represents a single condition in a condition group.
 *
 * @author  Jeroen Sormani
 * @version 1.0.0
 */
class WAFS_Condition {


	/**
	 * Condition ID.
	 *
	 * @since 1.0.0
	 * @var string $id Condition ID.
	 */
	public $id;

	/**
	 * Condition.
	 *
	 * @since 1.0.0
	 * @var string $condition Condition slug.
	 */
	public $condition;

	/**
	 * Operator.
	 *
	 * @since 1.0.0
	 * @var string $operator Operator slug.
	 */
	public $operator;

	/**
	 * Value.
	 *
	 * @since 1.0.0
	 * @var string $value Condition value.
	 */
	public $value;

	/**
	 * Group ID.
	 *
	 * @since 1.0.0
	 * @var string $group Condition group ID.
	 */
	public $group;


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $id = null, $group = 0, $condition = 'subtotal', $operator = null, $value = null ) {

		$this->id        = $id;
		$this->group     = $group;
		$this->condition = $condition;
		$this->operator  = $operator;
		$this->value     = $value;

		if ( ! $id ) {
			$this->id = rand();
		}

	}


	/**
	 * Output condition row.
	 *
	 * Output the full condition row which includes: condition, operator, value, add/delete buttons and
	 * the description.
	 *
	 * @since 1.1.6
	 */
	public function output_condition_row() {

		$wp_condition = $this;
		require 'views/html-condition-row.php';

	}


	/**
	 * Get conditions.
	 *
	 * Get a list with the available conditions.
	 *
	 * @since 1.1.6
	 *
	 * @return  array  List of available conditions for a condition row.
	 */
	public function get_conditions() {

		$conditions = array(
			__( 'Cart', 'woocommerce-advanced-free-shipping' ) => array(
				'subtotal'                => __( 'Subtotal', 'woocommerce-advanced-free-shipping' ),
				'subtotal_ex_tax'         => __( 'Subtotal ex. taxes', 'woocommerce-advanced-free-shipping' ),
				'tax'                     => __( 'Tax', 'woocommerce-advanced-free-shipping' ),
				'quantity'                => __( 'Quantity', 'woocommerce-advanced-free-shipping' ),
				'contains_product'        => __( 'Contains product', 'woocommerce-advanced-free-shipping' ),
				'coupon'                  => __( 'Coupon', 'woocommerce-advanced-free-shipping' ),
				'weight'                  => __( 'Weight', 'woocommerce-advanced-free-shipping' ),
				'contains_shipping_class' => __( 'Contains shipping class', 'woocommerce-advanced-free-shipping' ),
			),
			__( 'User Details', 'woocommerce-advanced-free-shipping' ) => array(
				'zipcode' => __( 'Zipcode', 'woocommerce-advanced-free-shipping' ),
				'city'    => __( 'City', 'woocommerce-advanced-free-shipping' ),
				'state'   => __( 'State', 'woocommerce-advanced-free-shipping' ),
				'country' => __( 'Country', 'woocommerce-advanced-free-shipping' ),
				'role'    => __( 'User role', 'woocommerce-advanced-free-shipping' ),
			),
			__( 'Product', 'woocommerce-advanced-free-shipping' ) => array(
				'width'        => __( 'Width', 'woocommerce-advanced-free-shipping' ),
				'height'       => __( 'Height', 'woocommerce-advanced-free-shipping' ),
				'length'       => __( 'Length', 'woocommerce-advanced-free-shipping' ),
				'stock'        => __( 'Stock', 'woocommerce-advanced-free-shipping' ),
				'stock_status' => __( 'Stock status', 'woocommerce-advanced-free-shipping' ),
				'category'     => __( 'Category', 'woocommerce-advanced-free-shipping' ),
			),
		);
		$conditions = apply_filters( 'wafs_conditions', $conditions );

		return $conditions;

	}


	/**
	 * Get available operators.
	 *
	 * Get a list with the available operators for the conditions.
	 *
	 * @since 1.1.6
	 *
	 * @return  array  List of available operators.
	 */
	public function get_operators() {
		$wpc_condition = wpc_get_condition( $this->condition );
		return apply_filters( 'woocommerce_Advanced_Shipping_Validation_operators', $wpc_condition->get_available_operators() );
	}


	/**
	 * Get value field args.
	 *
	 * Get the value field args that are condition dependent. This usually includes
	 * type, class and placeholder.
	 *
	 * @since 1.1.6
	 *
	 * @return  array
	 */
	public function get_value_field_args() {

		// Defaults
		$default_field_args = array(
			'name'        => 'conditions[' . absint( $this->group ) . '][' . absint( $this->id ) . '][value]',
			'placeholder' => '',
			'type'        => 'text',
			'class'       => array( 'wpc-value' ),
		);

		$field_args = $default_field_args;
		if ( $condition = wpc_get_condition( $this->condition ) ) {
			$field_args = wp_parse_args( $condition->get_value_field_args(), $field_args );
		}

		if ( $this->condition == 'contains_product' && $product = wc_get_product( $this->value ) ) {
			$field_args['custom_attributes']['data-selected'] = $product->get_formatted_name(); // WC < 2.7
			$field_args['options'][ $this->value ] = $product->get_formatted_name(); // WC >= 2.7
		}

		$field_args = apply_filters( 'wafs_values', $field_args, $this->condition );
		$field_args = apply_filters( 'woocommerce_advanced_free_shipping_values', $field_args, $this->condition );

		return $field_args;

	}


	/**
	 * Get description.
	 *
	 * Return the description related to this condition.
	 *
	 * @since 1.0.0
	 */
	public function get_description() {
		$descriptions = apply_filters( 'wafs_descriptions', wpc_condition_descriptions() );
		return isset( $descriptions[ $this->condition ] ) ? $descriptions[ $this->condition ] : '';
	}


}
