<?php

function new_theme_setting_admin() {
?>
<div class="wrap">
    <h2><?php _e( 'Theme', 'new' ); ?></h2>
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <td scope="row"><label for="new_theme_about"><?php _e( 'About', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_about" rows="10" cols="35" id="new_theme_about" class="large-text code"><?php form_option( 'new_theme_about' ); ?></textarea>
                    <p><?php _e( 'Display on your homepage footer about.', 'new' ); ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row"><label for="new_theme_license"><?php _e( 'License', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_license" rows="3" cols="35" id="new_theme_license" class="large-text code"><?php form_option( 'new_theme_license' ); ?></textarea>
                    <p><?php _e( 'Show your ICP license.', 'new' ); ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row"><label for="new_theme_share"><?php _e( 'Share', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_share" rows="10" cols="35" id="new_theme_share" class="large-text code"><?php form_option( 'new_theme_share' ); ?></textarea>
                    <p><?php _e( 'Share javascript.', 'new' ); ?></p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
        <input type="hidden" name="action" value="edit" />
    </form>
</div>
<?php
}

function new_theme_setting_page() {
    if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'edit' ) {
        $new_theme_about = _filter_object_empty( $_REQUEST, 'new_theme_about', get_option( 'new_theme_about' ) );
        update_option( 'new_theme_about', esc_html( $new_theme_about ) );
        $new_theme_license = _filter_object_empty( $_REQUEST, 'new_theme_license', get_option( 'new_theme_license' ) );
        update_option( 'new_theme_license', esc_html( $new_theme_license ) );
        $new_theme_share = _filter_object_empty( $_REQUEST, 'new_theme_share', get_option( 'new_theme_share' ) );
        update_option( 'new_theme_share', wp_unslash( $new_theme_share ) );
    }

    add_theme_page( 'new_theme_setting', 'Theme Setting', 'manage_options', basename( __FILE__ ), 'new_theme_setting_admin' );
}
add_action( 'admin_menu', 'new_theme_setting_page' );
