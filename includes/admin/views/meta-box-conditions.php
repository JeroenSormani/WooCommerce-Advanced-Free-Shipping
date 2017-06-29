<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
$condition_groups = get_post_meta( $post->ID, '_wafs_shipping_method_conditions', true );

?><div class='wpc-conditions wpc-conditions-meta-box'>
	<div class='wpc-condition-groups'>

		<p>
			<strong><?php _e( 'Match one of the condition groups to allow free shipping:', 'woocommerce-advanced-free-shipping' ); ?></strong>
		</p><?php

		if ( ! empty( $condition_groups ) ) :

			foreach ( $condition_groups as $condition_group => $conditions ) :
				include plugin_dir_path( __FILE__ ) . 'html-condition-group.php';
			endforeach;

		else :

			$condition_group = '0';
			include plugin_dir_path( __FILE__ ) . 'html-condition-group.php';

		endif;

	?></div>

	<div class='wpc-condition-group-template hidden' style='display: none'><?php
		$condition_group = '9999';
		$conditions      = array();
		include plugin_dir_path( __FILE__ ) . 'html-condition-group.php';
	?></div>
	<a class='button wpc-condition-group-add' href='javascript:void(0);'><?php _e( 'Add \'Or\' group', 'woocommerce-advanced-free-shipping' ); ?></a>
</div>