<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Role_Condition' ) ) {

	class WPC_Role_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Role', 'wpc-conditions' );
			$this->slug        = __( 'role', 'wpc-conditions' );
			$this->group       = __( 'User', 'wpc-conditions' );
			$this->description = __( 'Compare against the user role', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value     = $this->get_value( $value );
			$user_caps = $this->get_compare_value();

			if ( '==' == $operator ) :
				$match = ( array_key_exists( $value, $user_caps ) );
			elseif ( '!=' == $operator ) :
				$match = ( ! array_key_exists( $value, $user_caps ) );
			endif;

			return $match;

		}

		public function get_compare_value() {
			if ( is_user_logged_in() ) {
				global $current_user;
				return $current_user->caps;
			} else {
				return array( 'not_logged_in' => 'not_logged_in' );
			}

		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$user_roles = array_keys( get_editable_roles() );
			$user_roles = array_combine( $user_roles, $user_roles );
			$user_roles['not_logged_in'] = __( 'Guest user', 'wp-conditions' );

			$field_args = array(
				'type' => 'select',
				'class' => array( 'wpc-value' ),
				'options' => $user_roles,
			);

			return $field_args;

		}

	}

}