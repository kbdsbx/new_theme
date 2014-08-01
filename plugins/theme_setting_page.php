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
                <td scope="row"><label for="new_theme_default_source"><?php _e( 'Default source', 'new' ); ?></label></td>
                <td>
                    <input type="text" id="new_theme_default_source" name="new_theme_default_source" class="regular-text code" value="<?php form_option( 'new_theme_default_source' ); ?>" />
                    <p><?php _e( 'If you empty the article\'s source for create new, this is the default source.', 'new' ); ?></p>
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
        update_option( 'new_theme_about', $new_theme_about );
        $new_theme_license = _filter_object_empty( $_REQUEST, 'new_theme_license', get_option( 'new_theme_license' ) );
        update_option( 'new_theme_license', $new_theme_license );
        $new_theme_default_source = _filter_object_empty( $_REQUEST, 'new_theme_default_source', get_option( 'new_theme_default_source' ) );
        update_option( 'new_theme_default_source', $new_theme_default_source);
    }

    add_theme_page( 'new_theme_setting', 'Theme Setting', 'manage_options', basename( __FILE__ ), 'new_theme_setting_admin' );
}
add_action( 'admin_menu', 'new_theme_setting_page' );
