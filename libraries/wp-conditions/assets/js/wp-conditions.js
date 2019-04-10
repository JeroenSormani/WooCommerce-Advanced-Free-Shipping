jQuery( function( $ ) {

    function wpc_condition_group_repeater() {
        // Condition group repeater
        $( '.wpc-conditions' ).repeater({
            addTrigger: '.wpc-condition-group-add',
            removeTrigger: '.wpc-condition-group .delete',
            template: '.wpc-condition-group-template .wpc-condition-group-wrap',
            elementWrap: '.wpc-condition-group-wrap',
            elementsContainer: '.wpc-condition-groups',
            removeElement: function( el ) {
                el.remove();
            }
        });
    }
    wpc_condition_group_repeater();


    function wpc_condition_row_repeater() {
        // Condition repeater
        $( '.wpc-condition-group' ).repeater({
            addTrigger: '.wpc-condition-add',
            removeTrigger: '.wpc-condition-delete',
            template: '.wpc-condition-template .wpc-condition-wrap',
            elementWrap: '.wpc-condition-wrap',
            elementsContainer: '.wpc-conditions-list',
        });
    }
    wpc_condition_row_repeater();


    // Assign new ID to repeater row + open collapsible + re-enable nested repeater
    jQuery( document.body ).on( 'repeater-added-row', function( e, template, container, $self ) {
        var new_id = Math.floor(Math.random()*899999999+100000000); // Random number sequence of 9 length
        template.find( 'input[name], select[name]' ).attr( 'name', function( index, value ) {
            return ( value.replace( '9999', new_id ) ) || value;
        });
        template.find( '.wpc-condition[data-id]' ).attr( 'data-id', function( index, value ) {
            return ( value.replace( '9999', new_id ) ) || value;
        });
        // Fix #20 - condition IDs being replaced by group IDs
        template.find( '.wpc-condition-template .wpc-condition[data-id]' ).attr( 'data-id', '9999' );

        template.find( '[data-group]' ).attr( 'data-group', function( index, value ) {
            return ( value.replace( '9999', new_id ) ) || value;
        });

        template.find( '.repeater-active' ).removeClass( 'repeater-active' );

        // Init condition group repeater
        wpc_condition_row_repeater();
    });


    // Duplicate condition group
    $( document.body ).on ( 'click', '.wpc-conditions .duplicate', function() {
        var condition_group_wrap = $( this ).parents( '.wpc-condition-group-wrap' ),
            condition_group_id   = condition_group_wrap.find( '.wpc-condition-group' ).attr( 'data-group' ),
            condition_group_list = $( this ).parents( '.wpc-condition-groups' ),
            new_group            = condition_group_wrap.clone(),
            new_group_id         = Math.floor(Math.random()*899999999+100000000); // Random number sequence of 9 length

        // Fix dropdown selected not being cloned properly
        $( condition_group_wrap ).find( 'select' ).each(function(i) {
            $( new_group ).find( 'select' ).eq( i ).val( $( this ).val() );
        });

        // Assign proper names
        new_group.find( '.wpc-condition-group' ).attr( 'data-group', new_group_id );
        new_group.find( 'input[name], select[name]' ).attr( 'name', function( index, name ) {
            return name.replace( 'conditions[' + condition_group_id + ']', 'conditions[' + new_group_id + ']' );
        });

        new_group.find( '.repeater-active' ).removeClass( 'repeater-active' );
        condition_group_list.append( new_group );

        // Enable Select2's
        //$( document.body ).trigger( 'wc-enhanced-select-init' );

        // Init condition repeater
        wpc_condition_row_repeater();

        // Stop autoscroll on manual scrolling
        $( 'html, body' ).on( "scroll mousedown DOMMouseScroll mousewheel keydown touchmove", function( e ) {
            $( 'html, body' ).stop().off('scroll mousedown DOMMouseScroll mousewheel keydown touchmove');
        });

        // Autoscroll to new group
        $( 'body, html' ).animate({ scrollTop: $( new_group ).offset().top - 50 }, 750, function() {
            $( 'html, body' ).off('scroll mousedown DOMMouseScroll mousewheel keydown touchmove');
        });

    });


    // Update condition values
    $( document.body ).on( 'change', '.wpc-condition', function () {

        var loading_wrap = '<span style="width: calc( 42.5% - 75px ); border: 1px solid transparent; display: inline-block;">&nbsp;</span>';
        var data = {
            action: 	wpc2.action_prefix + 'update_condition_value',
            id:			$( this ).attr( 'data-id' ),
            group:		$( this ).parents( '.wpc-condition-group' ).attr( 'data-group' ),
            condition: 	$( this ).val(),
            nonce: 		wpc.nonce
        };
        var condition_wrap = $( this ).parents( '.wpc-condition-wrap' ).first();
        var replace = '.wpc-value-field-wrap';

        // Loading icon
        condition_wrap.find( replace ).html( loading_wrap ).block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

        // Replace value field
        $.post( ajaxurl, data, function( response ) {
            condition_wrap.find( replace ).replaceWith( response );
            $( document.body ).trigger( 'wc-enhanced-select-init' );
        });

        // Update operators
        var operator_value = condition_wrap.find( '.wpc-operator' ).val();
        condition_wrap.find( '.wpc-operator' ).empty().html( function() {
            var operator = $( this );
            var available_operators = wpc.condition_operators[ data.condition] || wpc.condition_operators['default'];

            $.each( available_operators, function( index, value ) {
                operator.append( $('<option/>' ).attr( 'value', index ).text( value ) );
                operator.val( operator_value ).val() || operator.val( operator.find( 'option:first' ).val() );
            });
        });

        // Update condition description
        condition_wrap.find( '.wpc-description' ).html( function() {
            return $( '<span class="woocommerce-help-tip" />' ).attr( 'data-tip', ( wpc.condition_descriptions[ data.condition ] || '' ) );
        });
        $( '.tips, .help_tip, .woocommerce-help-tip' ).tipTip({ 'attribute': 'data-tip', 'fadeIn': 50, 'fadeOut': 50, 'delay': 200 });
        $( '#tiptip_holder' ).removeAttr( 'style' );
        $( '#tiptip_arrow' ).removeAttr( 'style' );

    });


    // Sortable post table
    $( '.wpc-conditions-post-table.wpc-sortable-post-table tbody' ).sortable({
        items:					'tr',
        handle:					'.sort',
        cursor:					'move',
        axis:					'y',
        scrollSensitivity:		40,
        forcePlaceholderSize: 	true,
        helper: 				'clone',
        opacity: 				0.65,
        placeholder: 			'wc-metabox-sortable-placeholder',
        start: function(event,ui){
            ui.item.css( 'background-color','#f6f6f6' );
        },
        stop: function(event,ui){
            ui.item.removeAttr( 'style' );
        },
        update: function(event, ui) {

            $table 	= $( this ).closest( 'table' );
            $table.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
            // Update fee order
            var data = {
                action:	'wpc_save_post_order',
                form: 	$( this ).closest( 'form' ).serialize(),
                nonce: 	wpc.nonce
            };

            $.post( ajaxurl, data, function( response ) {
                $( '.wpc-conditions-post-table tbody tr:even' ).addClass( 'alternate' );
                $( '.wpc-conditions-post-table tbody tr:odd' ).removeClass( 'alternate' );
                $table.unblock();
            });
        }
    });

});