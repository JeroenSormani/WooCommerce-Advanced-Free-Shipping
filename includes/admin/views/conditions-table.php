<?php
/**
 * Conditions table
 *
 * Display table with all the user configured Free shipping conditions
 *
 * @author		Jeroen Sormani
 * @package 	WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */
$method_conditions = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'wafs' ) );
?>
<tr valign="top">
	<th scope="row" class="titledesc">
		<?php _e( 'Method conditions', 'wafs' ); ?>:<br />
		<small>Read more</small>
	</th>
	<td class="forminp" id="<?php echo $this->id; ?>_flat_rates">

		<table class='wp-list-table wafs-table widefat'>
			<thead>
				<tr>
					<th style='padding-left: 10px;'><?php _e( 'Title', 'wafs' ); ?></th>
					<th><?php _e( 'Shipping title', 'wafs' ); ?></th>
					<th><?php _e( 'Condition groups', 'wafs' ); ?></th>
					<th><?php _e( 'Author', 'wafs' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $method_conditions as $method_condition ) :
					$method_details = get_post_meta( $method_condition->ID, '_wafs_shipping_method', true );
					$conditions 	= get_post_meta( $method_condition->ID, '_wafs_shipping_method_conditions', true );
				?>
					<tr>
						<td>
							<strong>
								<a href='<?php echo get_edit_post_link( $method_condition->ID ); ?>' class='row-title' title='<?php _e( 'Edit Method', 'wafs' ); ?>'>
									<?php echo $method_condition->post_title; echo empty( $method_condition->post_title) ? __( 'Untitled', 'wafs' ) : null; ?>
								</a>
							</strong>
							<div class='row-actions'>
								<span class='edit'>
									<a href='<?php echo get_edit_post_link( $method_condition->ID ); ?>' title='<?php _e( 'Edit Method', 'wafs' ); ?>'>
										<?php _e( 'Edit', 'wafs' ); ?>
									</a>
									 |
								</span>
								<span class='trash'>
									<a href='<?php echo get_delete_post_link( $method_condition->ID ); ?>' title='<?php _e( 'Delete Method', 'wafs' ); ?>'>
										<?php _e( 'Delete', 'wafs' ); ?>
									</a>
								</span>
							</div>
						</td>
						<td><?php echo empty( $method_details['shipping_title'] ) ? __( 'Free Shipping', 'wafs') : $method_details['shipping_title']; ?></td>
						<td><?php echo count( $conditions ); ?></td>
						<td><?php echo get_the_author_meta( 'display_name', $method_condition->post_author ); ?></a>
						</td>
					</tr>
					<?php
				endforeach;
				
				if ( empty( $method_conditions ) ) :
					?>
					<tr>
						<td colspan='2'><?php _e( 'There are no Free Shipping conditions. Yet...', 'wafs' ); ?></td>
					</tr>
					<?php
				endif;
				?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan='4' style='padding-left: 10px;'>
						<a href='<?php echo admin_url( 'post-new.php?post_type=wafs' ); ?>' class='add button'><?php _e( 'Add Free Shipping Method', 'wapl' ); ?></a>
					</th>
				</tr>
			</tfoot>
		</table>
	</td>
</tr>