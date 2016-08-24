<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'wpc_html_field' ) ) {

	/**
	 * Output html field.
	 *
	 * Output a new HTML field.
	 *
	 * @since 1.1.6
	 *
	 * @param  array  $args
	 */
	function wpc_html_field( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'id'                => '',
			'type'              => 'text',
			'name'              => '',
			'class'             => '',
			'value'             => null,
			'default'           => '',
			'placeholder'       => '',
			'custom_attributes' => isset( $args['custom_attr'] ) ? $args['custom_attr'] : array(), // BC
		) );

		$type              = ! empty( $args['field'] ) ? $args['field'] : $args['type'];
		$class             = is_array( $args['class'] ) ? implode( ' ', array_map( 'sanitize_html_class', $args['class'] ) ) : sanitize_html_class( $args['class'] );
		$value             = isset( $args['value'] ) ? $args['value'] : '';
		$name              = isset( $args['name'] ) ? $args['name'] : $args['id'];
		$custom_attributes = array();
		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $k => $v ) {
				$custom_attributes[ $k ] = esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
			}
		}

		switch ( $type ) :

			case 'text' :
			case 'number' :
				?><input
					name="<?php echo esc_attr( $name ); ?>"
					type="<?php echo $args['type']; ?>"
					id="<?php echo esc_attr( $args['id'] ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					class="input-text <?php echo $class; ?>"
					<?php echo implode( ' ', $custom_attributes ); ?>
					placeholder='<?php echo esc_attr( $args['placeholder'] ); ?>'
				><?php
				break;

			case 'dropdown' :
			case 'select' :

				$options = is_array( $args['options'] ) ? $args['options'] : array();

				?><select
					name="<?php echo esc_attr( $args['name'] ); ?>"
					id="<?php echo esc_attr( $args['id'] ); ?>"
					class="input-select <?php echo $class; ?>"
					<?php echo implode( ' ', $custom_attributes ); ?>
				><?php

					foreach ( $options as $index => $values ) :

						if ( ! is_array( $values ) ) :
							?><option value='<?php echo esc_attr( $index ); ?>' <?php selected( $index, $value ); ?>><?php echo esc_attr( $values ); ?></option><?php
						else :
							?><optgroup label='<?php echo esc_attr( $index ); ?>'><?php
								foreach ( $values as $k => $v ) :
									?><option value='<?php echo esc_attr( $k ); ?>' <?php selected( $k, $value ); ?>><?php echo esc_attr( $v ); ?></option><?php
								endforeach;
							?></optgroup><?php
						endif;

					endforeach;

					if ( empty( $options ) ) :
						?><option readonly disabled><?php
							_e( 'There are no options available', 'woocommerce-advanced-fees' );
						?></option><?php
					endif;

				?></select><?php
				break;

			default :
			case 'hook' :

				do_action( 'woocommerce_advanced_fees_condition_value_field_type_' . $args['type'], $args );
				break;

		endswitch;

	}


}
