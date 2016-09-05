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
	public function __construct( $id = null, $group = 0, $condition = null, $operator = null, $value = null ) {

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

		$operators = array(
			'==' => __( 'Equal to', 'woocommerce-advanced-free-shipping' ),
			'!=' => __( 'Not equal to', 'woocommerce-advanced-free-shipping' ),
			'>=' => __( 'Greater or equal to', 'woocommerce-advanced-free-shipping' ),
			'<=' => __( 'Less or equal to ', 'woocommerce-advanced-free-shipping' ),
		);
		$operators = apply_filters( 'wafs_operators', $operators );

		return $operators;

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
		$values = array(
			'name'        => 'conditions[' . absint( $this->group ) . '][' . absint( $this->id ) . '][value]',
			'placeholder' => '',
			'type'        => 'text',
			'class'       => array( 'wpc-value' )
		);



		switch ( $this->condition ) :

			default:
			case 'subtotal' :
			case 'subtotal_ex_tax' :
			case 'tax' :
			case 'quantity' :
			case 'coupon' :
			case 'weight' :
				$values['type'] = 'text';
			break;

			case 'contains_product' :

				$product = wc_get_product( $this->value );
				if ( $product ) {
					$values['custom_attributes']['data-selected'] = $product->get_formatted_name();
				}

				$values['type']        = 'text';
				$values['placeholder'] =  __( 'Search for a product', 'woocommerce-advanced-messages' );
				$values['class'][]     = 'wc-product-search';

			break;

			case 'contains_shipping_class' :

				$values['type']        = 'select';
				$values['options'][''] = __( 'No shipping class', 'woocommerce' );

				// Get all shipping classes
				foreach ( get_terms( 'product_shipping_class', array( 'hide_empty' => false ) ) as $shipping_class ) :
					$values['options'][ $shipping_class->slug ] = $shipping_class->name;
				endforeach;

			break;

			/**
			 * User details
			 */

			case 'zipcode' :
			case 'city' :
				$values['type'] = 'text';
			break;

			case 'state' :

				$values['type']    = 'select';
				$values['class'][] = 'wc-enhanced-select';

				$country_states = array();
				foreach ( WC()->countries->states as $country => $states ) :

					if ( empty( $states ) ) continue; // Don't show country if it has no states
					if ( ! array_key_exists( $country, WC()->countries->get_allowed_countries() ) ) continue; // Skip unallowed countries

					foreach ( $states as $state_key => $state ) :
						$country_states[ WC()->countries->countries[ $country ] ][ $country . '_' . $state_key ] = $state;
					endforeach;

					$values['options'] = $country_states;

				endforeach;

			break;

			case 'country' :

				$values['field']   = 'select';
				$values['class'][] = 'wc-enhanced-select';

				$countries  =  WC()->countries->get_allowed_countries() + WC()->countries->get_shipping_countries();
				$continents = array();
				if ( method_exists( WC()->countries, 'get_continents' ) ) :
					foreach ( WC()->countries->get_continents() as $k => $v ) :
						$continents[ 'CO_' . $k ] = $v['name']; // Add prefix for country key compatibility
					endforeach;
				endif;

				if ( $continents ) {
					$values['options'][ __( 'Continents', 'woocommerce' ) ] = $continents;
				}
				$values['options'][ __( 'Countries', 'woocommerce' ) ] = $countries;

				break;

			case 'role' :
				$values['type']    = 'select';
				$roles             = array_keys( get_editable_roles() );
				$values['options'] = array_combine( $roles, $roles );
			break;

			/**
			 * Product
			 */

			case 'width' :
			case 'height' :
			case 'length' :
			case 'stock' :
				$values['type'] = 'text';
			break;

			case 'stock_status' :

				$values['type']    = 'select';
				$values['options'] = array(
					'instock'    => __( 'In stock', 'woocommerce-advanced-free-shipping' ),
					'outofstock' => __( 'Out of stock', 'woocommerce-advanced-free-shipping' ),
				);

			break;

			case 'category' :

				$values['type']    = 'select';
				$values['class'][] = 'wc-enhanced-select';

				$categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
				foreach ( $categories as $category ) :
					$values['options'][ $category->slug ] = $category->name;
				endforeach;

			break;


		endswitch;

		$values = apply_filters( 'wafs_values', $values, $this->condition );


		$values = apply_filters( 'woocommerce_advanced_free_shipping_values', $values, $this->condition );

		return $values;

	}


	/**
	 * Get description.
	 *
	 * Return the description related to this condition.
	 *
	 * @since 1.0.0
	 */
	public function get_description() {

		$descriptions = array(
			'state'                   => __( 'States must be installed in WC.', 'woocommerce-advanced-free-shipping' ),
			'weight'                  => __( 'Weight calculated on all the cart contents', 'woocommerce-advanced-free-shipping' ),
			'length'                  => __( 'Compared to lengthiest product in cart', 'woocommerce-advanced-free-shipping' ),
			'width'                   => __( 'Compared to widest product in cart', 'woocommerce-advanced-free-shipping' ),
			'height'                  => __( 'Compared to highest product in cart', 'woocommerce-advanced-free-shipping' ),
			'stock_status'            => __( 'All products in cart must match stock status', 'woocommerce-advanced-free-shipping' ),
			'category'                => __( 'All products in cart must match category', 'woocommerce-advanced-free-shipping' ),
			'contains_product'        => __( 'Cart must contain one of this product', 'woocommerce-advanced-free-shipping' ),
			'contains_shipping_class' => __( 'Cart must contain at least one product with the selected shipping class', 'woocommerce-advanced-free-shipping' ),
		);

		$descriptions = apply_filters( 'wafs_descriptions', $descriptions );

		return isset( $descriptions[ $this->condition ] ) ? $descriptions[ $this->condition ] : '';

	}


}
