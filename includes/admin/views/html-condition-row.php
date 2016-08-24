<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?><div class='wpc-condition-wrap'>

	<!-- Condition -->
	<span class='wpc-condition-wrap wpc-condition-wrap-<?php echo absint( $wp_condition->id ); ?>'><?php

		$condition_field_args = array(
			'type'        => 'select',
			'name'        => 'conditions[' . absint( $wp_condition->group ) . '][' . absint( $wp_condition->id ) . '][condition]',
			'class'       => array( 'wpc-condition' ),
			'options'     => $wp_condition->get_conditions(),
			'value'       => $wp_condition->condition,
			'custom_attr' => array(
				'data-group' => absint( $wp_condition->group ),
				'data-id'    => absint( $wp_condition->id ),
			),
		);
		wpc_html_field( $condition_field_args );

	?></span>


	<!-- Operator -->
	<span class='wpc-operator-wrap wpc-operator-wrap-<?php echo absint( $wp_condition->id ); ?>'><?php

		$operator_field_args = array(
			'type'    => 'select',
			'name'    => 'conditions[' . absint( $wp_condition->group ) . '][' . absint( $wp_condition->id ) . '][operator]',
			'class'   => array( 'wpc-operator' ),
			'options' => $wp_condition->get_operators(),
			'value'   => $wp_condition->operator,
		);
		wpc_html_field( $operator_field_args );

	?></span>


	<!-- Value -->
	<span class='wpc-value-wrap wpc-value-wrap-<?php echo absint( $wp_condition->id ); ?>'><?php
		$value_field_args = wp_parse_args( array( 'value' => $wp_condition->value ), $wp_condition->get_value_field_args() );
		wpc_html_field( $value_field_args );
	?></span>


    <!-- Add / Delete-->
	<a class='button wpc-condition-add' data-group='<?php echo absint( $this->group ); ?>' href='javascript:void(0);'>+</a>&nbsp;
	<a class='button wpc-condition-delete' href='javascript:void(0);'>-</a><?php


	// Description
	if ( $desc = $wp_condition->get_description() ) :
		?><span class='wpc-description <?php echo $wp_condition->condition; ?>-description'>
			<img class='help_tip' src='<?php echo WC()->plugin_url(); ?>/assets/images/help.png' height='24' width='24' data-tip="<?php echo esc_html( $desc ); ?>" />
		</span><?php
	else :
		?><span class='wpc-description wpc-no-description <?php echo $wp_condition->condition; ?>-description'><?php
	endif;

?></div>
