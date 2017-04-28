<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Condition' ) ) {

	abstract class WPC_Condition {

		protected $name = null;
		protected $slug = null;
		protected $group = null;
		protected $description = null;
		protected $value_field_args = array();
		protected $available_operators = array();

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( is_null( $this->get_slug() ) ) {
				$this->slug = sanitize_key( $this->get_name() );
			}
		}

		public function get_name() {
			return $this->name;
		}

		public function get_slug() {
			return $this->slug;
		}

		public function get_group() {
			return $this->group;
		}

		/**
		 * @return array
		 */
		public function get_available_operators() {

			if ( empty( $this->available_operators ) ) {
				$this->available_operators = array(
					'==' => __( 'Equal to', 'wpc-conditions' ),
					'!=' => __( 'Not equal to', 'wpc-conditions' ),
					'>=' => __( 'Greater or equal to', 'wpc-conditions' ),
					'<=' => __( 'Less or equal to ', 'wpc-conditions' ),
				);
			}

			return $this->available_operators;

		}

		public function get_value_field_args() {

			if ( empty( $this->value_field_args ) ) {
				$this->value_field_args = array(
					'type'        => 'text',
					'class'       => array( 'wpc-value' ),
					'placeholder' => '',
				);
			}

			return $this->value_field_args;

		}

		/**
		 * Get condition value.
		 *
		 * Get the value the store owner has set.
		 *
		 * @since 1.0.0
		 *
		 * @param $value
		 * @return string
		 */
		public function get_value( $value ) {
			return $value;
		}

		/**
		 * Get the compare value.
		 *
		 * Get the value the main value should compare against.
		 *
		 * @since 1.0.0
		 *
		 * @return string|mixed The value to compare the store-owner set value against.
		 */
		public function get_compare_value() {

			$compare_value = '';
			return $compare_value;
		}

		public function match( $match, $operator, $value ) {

			if ( ! $this->validate() ) {
				return false;
			}

			$value = $this->get_value( $value );
			$compare_value = $this->get_compare_value();

			if ( '==' == $operator ) :
				$match = ( $compare_value == $value );
			elseif ( '!=' == $operator ) :
				$match = ( $compare_value != $value );
			elseif ( '>=' == $operator ) :
				$match = ( $compare_value >= $value );
			elseif ( '<=' == $operator ) :
				$match = ( $compare_value <= $value );
			endif;

			return $match;
		}

		/**
		 * Validates before matching function.
		 * Can be used for example to verify the global $product exists.
		 */
		public function validate() {
			return true;
		}

		public function get_description() {
			return $this->description;
		}

	}

}
