jQuery( function( $ ) {

	/**************************************************************
	 * WPC - 1.0.1
	 *************************************************************/

	// Add condition
	$( document.body ).on( 'click', '.wpc-condition-add', function() {

		var $this = $( this );
		var data = {
			action: wpc.action_prefix + 'add_condition',
			group: $( this ).attr( 'data-group' ),
			nonce: wpc.nonce
		};
		var condition_group = $this.parents( '.wpc-conditions' ).find( '.wpc-condition-group-' + data.group );

		var loading_icon = '<div class="wpc-condition-wrap loading"></div>';
		condition_group.append( loading_icon ).children( ':last' ).block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

		$.post( ajaxurl, data, function( response ) {
			condition_group.find( ' .wpc-condition-wrap.loading' ).first().replaceWith( function() {
				return $( response ).hide().fadeIn( 'normal' );
			});
		});

	});

	// Delete condition
	$( document.body ).on( 'click', '.wpc-condition-delete', function() {

		if ( $( this ).closest( '.wpc-condition-group' ).children( '.wpc-condition-wrap' ).length == 1 ) {
			$( this ).closest( '.wpc-condition-group' ).fadeOut( 'normal', function() {
				$( this ).next( '.or-text' ).remove();
				$( this ).remove();
			});
		} else {
			$( this ).closest( '.wpc-condition-wrap' ).slideUp( 'fast', function() { $( this ).remove(); });
		}

	});

	// Add condition group
	$( document.body ).on( 'click', '.wpc-condition-group-add', function() {

		var condition_group_loading = '<div class="wpc-condition-group loading"></div>';
		var conditions = $( this ).prev( '.wpc-conditions' );
		var data = {
			action: wpc.action_prefix + 'add_condition_group',
			group: 	parseInt( $( this ).prev( '.wpc-conditions' ).find( '.wpc-condition-group' ).length ),
			nonce: 	wpc.nonce
		};

		// Display loading icon
		conditions.append( condition_group_loading ).children( ':last' ).block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

		// Insert condition group
		$.post( ajaxurl, data, function( response ) {
			conditions.find( '.wpc-condition-group.loading' ).first().replaceWith( function() {
				return $( response ).hide().fadeIn( 'normal' );
			});
		});

	});

	// Update condition values
	$( document.body ).on( 'change', '.wpc-condition', function () {

		var loading_wrap = '<span style="width: 30%; border: 1px solid transparent; display: inline-block;">&nbsp;</span>';
		var data = {
			action: 	wpc.action_prefix + 'update_condition_value',
			id:			$( this ).attr( 'data-id' ),
			group:		$( this ).attr( 'data-group' ),
			condition: 	$( this ).val(),
			nonce: 		wpc.nonce
		};
		var condition_group = $( this ).parents( '.wpc-conditions' ).find( '.wpc-condition-group-' + data.group );
		var replace = '.wpc-value-wrap-' + data.id;

		// Loading icon
		condition_group.find( replace ).html( loading_wrap ).block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

		// Replace value field
		$.post( ajaxurl, data, function( response ) {
			condition_group.find( replace ).replaceWith( response );
			$( document.body ).trigger( 'wc-enhanced-select-init' );
		});

		// Update condition description
		var description = {
			action:		wpc.action_prefix + 'update_condition_description',
			condition: 	data.condition,
			nonce: 		wpc.nonce
		};

		$.post( ajaxurl, description, function( description_response ) {
			condition_group.find( replace + ' ~ .wpc-description' ).replaceWith( description_response );
			// Tooltip
			$( '.tips, .help_tip, .woocommerce-help-tip' ).tipTip({ 'attribute': 'data-tip', 'fadeIn': 50, 'fadeOut': 50, 'delay': 200 });
		})

	});

});