<?php

function _img_widget_update_js() {
?>
    <script>
( function( jQuery ) {
    var _ajax_bind;
    jQuery( _ajax_bind = function() {
		jQuery( '.choose-from-library-link' ).click( function( event ) {
			var $el = jQuery(this);
			event.preventDefault();
			           
			// If the media frame already exists, reopen it.
			if ( $el.frame ) {
				$el.frame.open();
				return;
			}
			
			// Create the media frame.
			$el.frame = wp.media({
				// Set the title of the modal.
				title: $el.data('choose'),
			
				// Tell the modal to show only images.
				library: {
					type: 'image'
				},
			
				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
			    }
			});
			
			// When an image is selected, run a callback.
			$el.frame.on( 'select', function() {
				// Grab the selected attachment.
                debugger;
				var attachment = $el.frame.state().get('selection').first(),
                    url = $el.data('updateUrl'),
                    action = $el.data('updateAction'),
                    preview = $el.data('updatePreview'),
                    preview_id = $el.data('updatePreviewId');
                jQuery.post( url, {
                    'attachment_id' : attachment.id,
                    'action' : action,
                }, function ( data ) {
                    debugger;
                    $el.parent().find( '#' + preview ).attr( 'src', data.data.asrc[0] );
                    $el.parent().find( '#' + preview ).attr( 'width', data.data.asrc[1] );
                    $el.parent().find( '#' + preview ).attr( 'height', data.data.asrc[2] );
                    $el.parent().find( '#' + preview_id ).val( attachment.id );
                    $el.frame.close();
                });
				// Tell the browser to navigate to the crop step.
				// window.location = window.location.href + ( window.location.search == "" ? "?" : "&" ) + name + '=' + attachment.id;
			});
			
			$el.frame.open();
		});
    });
}(jQuery));
    </script>
<?php
}

function _img_widget_update() {
    $aid = $_REQUEST['attachment_id'];
    $asrc = wp_get_attachment_image_src( $aid );

    $data = array (
        'aid' => $aid,
        'asrc' => $asrc
    );
    wp_send_json_success( $data );
}

function _add_script() { 
    wp_enqueue_media();
    wp_enqueue_script( 'imgareaselect' );
    wp_enqueue_style( 'imgareaselect' );
    // wp_enqueue_script( 'img_widget_js', get_template_directory_uri() . '/plugins/js/img_widget.js' );
}

function _filter_empty( $obj, $def ) {
    return empty( $obj ) ? $def : $obj;
}

function _filter_empty_array( $obj, $def ) {
    return is_array( $obj ) ? _filter_empty( $obj, $def ) : $def; 
}

function _filter_empty_numeric( $obj, $def ) {
    return is_numeric( $obj ) ? _filter_empty( $obj, $def ) : $def;
}

function _filter_object_empty( $obj, $param, $def ) {
    return isset( $obj[ $param ] ) ? _filter_empty( $obj[ $param ], $def ) : $def;
}
