<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * AJAX class.
 *
 * Handles all AJAX related calls.
 *
 * @author		Jeroen Sormani
 * @version		1.0.0
 */
class WAFS_Ajax {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Update elements
		add_action( 'wp_ajax_wafs_update_condition_value', array( $this, 'update_condition_value' ) );

	}


	/**
	 * Update condition value field.
	 *
	 * Output the HTML of the value field according to the condition key..
	 *
	 * @since 1.0.0
	 */
	public function update_condition_value() {

		check_ajax_referer( 'wpc-ajax-nonce', 'nonce' );

		$wp_condition     = new WAFS_Condition( $_POST['id'], $_POST['group'], $_POST['condition'] );
		$value_field_args = $wp_condition->get_value_field_args();

		?><span class='wpc-value-field-wrap'><?php
			wpc_html_field( $value_field_args );
		?></span><?php

		die();

	}


}
