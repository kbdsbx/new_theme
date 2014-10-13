<?php

function new_meta_box_save_post( $post_id ) {
    global $new_post_flags;

    $new_post_options = array();

    $new_post_options['new_post_flags'] = _filter_array_empty_array( $_POST, 'new_post_flags', array() );
    $new_post_options['new_post_view_count'] = _filter_array_empty_numeric( $_POST, 'new_post_view_count', 0 );
    $new_post_options['new_post_source'] = _filter_array_empty( $_POST, 'new_post_source', '' );

    update_post_meta( $post_id, 'new_post_options', $new_post_options );
}
add_action( 'save_post', 'new_meta_box_save_post' );

function new_add_meta_box_post_setting_html( $post ) {
    global $new_post_flags;
    $new_post_options = get_post_meta( $post->ID, 'new_post_options', true );
    if ( ! is_array( $new_post_options ) ) {
        $new_post_options = array();
    }
    $flags = _filter_array_empty( $new_post_options, 'new_post_flags', array() );
?>
    <label><?php _e( '文章标记：', 'new' ); ?></label>
    <div>
    <?php foreach( $new_post_flags as $key => $flag ) : ?>
    <label for="new_post_flags_<?php echo $key; ?>"><input type="checkbox" id="new_post_flags_<?php echo $key; ?>" name="new_post_flags[]" value="<?php echo $key; ?>" <?php if ( array_search( $key, $flags ) !== false ) { echo 'checked="checked"'; } ?> /><?php echo $flag; ?></label>
    <?php endforeach; ?>
    </div>
    <p><?php _e( '为你的文章添加标记，使之在页面中特殊的地方或以特殊的形式展示出来' ); ?></p>
    <hr />
    <label for="new_post_view_count"><?php _e( '文章浏览次数：', 'new' ); ?></label>
    <div>
        <input type="number" step="1" min="0" id="new_post_view_count" name="new_post_view_count" class="new-post-input" autocomplete="off" value="<?php echo _filter_array_empty_numeric( $new_post_options, 'new_post_view_count', 0 ); ?>" />
    </div>
    <p><?php printf( __( '若开启主题的文章浏览次数自动生成，当且仅当创建文章时会随机生成新的文章浏览次数，具体设置及生成数值范围请转至<a href="%s">主题设置</a>', 'new' ), admin_url( 'options-general.php?page=theme_setting_page.php' ) ); ?></p>
    <hr />
    <label for="new_post_source"><?php _e( '文章来源：', 'new' ); ?></label>
    <div>
        <input type="text" id="new_post_source" name="new_post_source" class="new-post-input" value="<?php echo _filter_array_empty( $new_post_options, 'new_post_source', '' ); ?>" />
    </div>
<?php 
}

function new_add_meta_box_source_setting_html( $post ) {
    $new_post_options = get_post_meta( $post->ID, 'new_source_options', true );
?>
    <label for="new_source_file"><?php _e( '文件：', 'new' ); ?></label>
    <div>
        <input type="text" id="new_source_file_name" readonly="readonly" class="new-post-input" />
        <input type="hidden" id="new_source_file" name="new_source_file" />
        <a class="button choose-from-library-link"
            data-update-url="<?php echo get_admin_url() . 'admin-ajax.php'; ?>"
            data-update-action="file_update"
            data-update-preview="#new_source_file_name"
            data-update-preview-id="#new_source_file"
            data-choose="<?php _e( '选择文件', 'new' ); ?>"
            data-update="<?php _e( '选择', 'new' ); ?>"><?php _e( '选择文件', 'new' ); ?></a>
        <?php _file_update_js(); ?>
    </div>
    <hr />
    <label for="new_source_type"><?php _e( '文件类型：', 'new' ); ?></label>
    <div id="new_source_type_div" class="cascade-load-auto" data-url="<?php echo new_expand_uri . '/file_type.json'; ?>" data-target="#new_source_type_div">
        <select id="new_source_type" name="new_source_type" data-cascade-layer="1"></select>
         -- 
        <select id="new_source_file_type" name="new_source_file_type" data-cascade-layer="2"></select>
    </div>
    <hr />
    <label for="new_source_file_size"><?php _e( '文件大小：', 'new' ); ?></label>
    <div>
        <input type="number" id="new_source_file_size" name="new_source_file_size" step="1" min="0" class="new-post-input" />&nbsp;
        <select id="new_source_file_size_quantity">
            <option value="Bit">Bit</option>
            <option value="Byte">Byte</option>
            <option value="KB">KB</option>
            <option value="MB">MB</option>
            <option value="GB">GB</option>
        </select>
    </div>
    <p><?php _e( '若您未填写此值，上传文件后会自动计算并填充，若再次上传文件时需要自动计算文件大小，请清空此值', 'new' ); ?></p>
<?php
}

/**
 * 添加普通文章所需属性的相关设置框
 */
function new_add_meta_box() {
    global $post_types_keys;
    foreach ( $post_types_keys as $post_type ) {
        add_meta_box(
            'new_post_options',
            __( '相关设置', 'new' ),
            'new_add_meta_box_post_setting_html',
            $post_type,
            'advanced'
        );
    }

    add_meta_box(
        'new_source_options',
        __( '资源相关设置', 'new' ),
        'new_add_meta_box_source_setting_html',
        'resource',
        'advanced'
    );
}
add_action( 'add_meta_boxes', 'new_add_meta_box' );

function _file_update_js() {
?>
<script>
( function( jQuery ) {
    jQuery( function() {
		jQuery( '.choose-from-library-link' ).off( "click" ).on( "click", function( event ) {
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
					// type: 'image'
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
                    preview_name = $el.data('updatePreview');
                    preview_id = $el.data('updatePreviewId');
                jQuery.post( url, {
                    'attachment_id' : attachment.id,
                    'action' : action,
                }, function ( data ) {
                    debugger;
                    jQuery( preview_name ).val( data.data.name );
                    jQuery( preview_id ).val( attachment.id );
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

function _file_update() {
    $aid = $_REQUEST['attachment_id'];
    $attachment_url = wp_get_attachment_url( $aid );
    $data = array (
        'aid' => $aid,
        'name' => $attachment_url
    );
    wp_send_json_success( $data );
}
add_action( 'wp_ajax_file_update', '_file_update' );
add_action( 'admin_enqueue_scripts', '_add_script' );

function new_add_dc_admin_body_class( $classes ) {
    return $classes . ' dc-on';
}
add_filter( 'admin_body_class', 'new_add_dc_admin_body_class' );

