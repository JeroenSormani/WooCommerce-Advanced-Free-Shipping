<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?><div class='wpc-condition-group-wrap'>
	<p class='or-text'><strong><?php _e( 'Or', 'woocommerce-advanced-free-shipping' ); ?></strong></p>

	<div class='wpc-condition-group clearfix' data-group='<?php echo absint( $condition_group ); ?>'>

		<span class='wpc-condition-group-actions alignright'>
			<a href='javascript:void(0);' class='duplicate'><?php _e( 'Duplicate', 'woocommerce-advanced-free-shipping' ); ?></a>&nbsp;|&nbsp;<a href='javascript:void(0);' class='delete'><?php _e( 'Delete', 'woocommerce-advanced-free-shipping' ); ?></a>
		</span>
		<p class='match-text'><?php _e( 'Match all of the following rules to allow free shipping:', 'woocommerce-advanced-free-shipping' ); ?></p>

		<div class='wpc-conditions-list'><?php

			if ( ! empty( $conditions ) ) :

				foreach ( $conditions as $condition_id => $condition ) :
					$wp_condition = new WAFS_Condition( $condition_id, $condition_group, $condition['condition'], $condition['operator'], $condition['value'] );
					$wp_condition->output_condition_row();
				endforeach;

			else :

				$wp_condition = new WAFS_Condition( null, $condition_group );
				$wp_condition->output_condition_row();

			endif;

		?></div>

		<div class="wpc-condition-template hidden" style="display: none;"><?php
			$wp_condition = new WAFS_Condition( '9999', $condition_group );
			$wp_condition->output_condition_row();
		?></div>
		<a style="margin-top: 0.5em; margin-right: 63px;" class='wpc-condition-add wpc-add button alignright' data-group='<?php echo absint( $condition_group ); ?>' href='javascript:void(0);'><?php _e( 'Add condition', 'woocommerce-advanced-free-shipping' ); ?></a>

	</div>
</div>
