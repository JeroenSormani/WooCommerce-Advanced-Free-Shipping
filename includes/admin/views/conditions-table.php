<?php
/**
 * Conditions table.
 *
 * Display table with all the user configured Free shipping conditions.
 *
 * @author		Jeroen Sormani
 * @package 	WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$shipping_rates = wafs_get_rates( array( 'post_status' => array( 'draft', 'publish' ) ) );

?><tr valign="top">
	<th scope="row" class="titledesc">
		<?php _e( 'Free shipping rates', 'woocommerce-advanced-free-shipping' ); ?><br />
	</th>
	<td class="forminp" id="<?php echo $this->id; ?>_shipping_methods">

		<table class='wp-list-table wpc-conditions-post-table wpc-sortable-post-table widefat'>
			<thead>
				<tr>
					<th style='padding-left: 10px;' class="column-primary"><?php _e( 'Title', 'woocommerce-advanced-free-shipping' ); ?></th>
					<th style='padding-left: 10px;'><?php _e( 'Shipping title', 'woocommerce-advanced-free-shipping' ); ?></th>
					<th style='padding-left: 10px;'><?php _e( 'Condition groups', 'woocommerce-advanced-free-shipping' ); ?></th>
				</tr>
			</thead>
			<tbody><?php

				$i = 0;
				foreach ( $shipping_rates as $post ) :

					$method_details = get_post_meta( $post->ID, '_wafs_shipping_method', true );
					$conditions     = get_post_meta( $post->ID, '_wafs_shipping_method_conditions', true );
					$alt            = ( $i++ ) % 2 == 0 ? 'alternate' : '';

					?><tr class='<?php echo $alt; ?>'>
						<td class="column-primary">
							<strong>
								<a href='<?php echo get_edit_post_link( $post->ID ); ?>' class='row-title' title='<?php _e( 'Edit Method', 'woocommerce-advanced-fees' ); ?>'><?php
									echo _draft_or_post_title( $post->ID );
								?></a><?php
								_post_states( $post );
							?></strong>
							<div class='row-actions'>
								<span class='edit'>
									<a href='<?php echo get_edit_post_link( $post->ID ); ?>' title='<?php _e( 'Edit Method', 'woocommerce-advanced-free-shipping' ); ?>'>
										<?php _e( 'Edit', 'woocommerce-advanced-free-shipping' ); ?>
									</a>
									|
								</span>
								<span class='trash'>
									<a href='<?php echo get_delete_post_link( $post->ID ); ?>' title='<?php _e( 'Delete Method', 'woocommerce-advanced-free-shipping' ); ?>'><?php
										_e( 'Delete', 'woocommerce-advanced-free-shipping' );
									?></a>
								</span>
							</div>
						</td>
						<td><?php echo empty( $method_details['shipping_title'] ) ? __( 'Free Shipping', 'woocommerce-advanced-free-shipping' ) : esc_html( $method_details['shipping_title'] ); ?></td>
						<td><?php echo count( $conditions ); ?></td>
					</tr><?php

				endforeach;

				if ( empty( $shipping_rates ) ) :
					?><tr>
						<td colspan='2' style="display: table-cell;"><?php _e( 'There are no Free Shipping rates. Yet...', 'woocommerce-advanced-free-shipping' ); ?></td>
					</tr><?php
				endif;

			?></tbody>
			<tfoot>
				<tr>
					<th colspan='4' style='padding-left: 10px; display: table-cell;'>
						<a href='<?php echo admin_url( 'post-new.php?post_type=wafs' ); ?>' class='add button'><?php _e( 'Add Free Shipping rate', 'woocommerce-advanced-free-shipping' ); ?></a>
					</th>
				</tr>
			</tfoot>
		</table>
	</td>
</tr>
