<?php

global $posts_flags;
$posts_flags = array(
	'headline',		// 头条
	'recommend',	// 推荐
	'slide',		// 幻灯
	'special',		// 特荐
	'roll',			// 滚动
	'blod',			// 加粗
	'picture',		// 图片
	'jump'			// 跳转
);

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function new_plugin_add_meta_box() {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'new_plugin_flags',
			__( 'This article\'s flags', 'new' ),
			'new_plugin_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'new_plugin_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function new_plugin_meta_box_callback( $post ) {
	global $posts_flags;
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'new_plugin_meta_box', 'new_plugin_meta_box_nonce' );
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	// $value = get_post_meta( $post->ID, '_new_meta_value_key', true );

	echo '<label for="new_plugin_new_field">';
	_e( 'Select flag with your article', 'new' );
	echo '</label> ';
	// echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';
	foreach ( $posts_flags as $flag ) {
		$value = get_post_meta( $post->ID, '_new_meta_article_' . $flag, true );
		echo '<label><input type="checkbox" id="'.$flag.'" name="'.$flag.'" value="true" ' . (esc_attr( $value ) == 'true' ? 'checked="checked"' : '') . '  />' . strtoupper( $flag ) . '</label>&nbsp;';
	}
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function new_plugin_save_meta_box_data( $post_id ) {
	global $posts_flags;

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['new_plugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['new_plugin_meta_box_nonce'], 'new_plugin_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	//if ( ! isset( $_POST['hot'] ) ) {
	//	$_POST['hot'] = 'false';
	//}
	foreach ( $posts_flags as $flag ) {
			if ( ! isset( $_POST[ $flag ] ) ) {
				$_POST[ $flag ] = 'false';
			}
			$my_data = sanitize_text_field( $_POST[ $flag ] );
			update_post_meta( $post_id, '_new_meta_article_' . $flag, $my_data );

			// $value = get_post_meta( $post->ID, '_new_meta_article_' . $flag, true );
			// echo '<input type="checkbox" id="'.$flag.'" name="'.$flag.'" value="true" ' . (esc_attr( $value ) == 'true' ? 'checked="checked"' : '') . '  />' . strtoupper( $flag );
	}

	// Sanitize user input.
	// $my_data = sanitize_text_field( $_POST['hot'] );

	// Update the meta field in the database.
	// update_post_meta( $post_id, '_new_meta_value_key', $my_data );
}
add_action( 'save_post', 'new_plugin_save_meta_box_data' );

?>
