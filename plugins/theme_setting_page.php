<?php

function new_theme_setting_admin() {
?>
<div class="wrap">
    <h2><?php _e( '其他设置', 'new' ); ?></h2>
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <td scope="row"><label for="new_theme_about"><?php _e( '关于', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_about" rows="10" cols="35" id="new_theme_about" class="large-text code"><?php form_option( 'new_theme_about' ); ?></textarea>
                    <p><?php _e( '显示主页脚部关于', 'new' ); ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row"><label for="new_theme_license"><?php _e( '声明', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_license" rows="3" cols="35" id="new_theme_license" class="large-text code"><?php form_option( 'new_theme_license' ); ?></textarea>
                    <p><?php _e( '显示关于本网站的ICP备案信息', 'new' ); ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row"><label for="new_theme_share"><?php _e( '分享', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_share" rows="10" cols="35" id="new_theme_share" class="large-text code"><?php form_option( 'new_theme_share' ); ?></textarea>
                    <p><?php _e( '每一篇文章中显示的分享脚本', 'new' ); ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row"><label for="new_theme_latest"><?php _e( '最新动态', 'new' ); ?></label></td>
                <td>
                    <textarea name="new_theme_latest" rows="10" cols="35" id="new_theme_latest" class="large-text code"><?php form_option( 'new_theme_latest' ); ?></textarea>
                    <p><?php _e( '在脚部中显示的个人或企业最新动态，使用第三方社交平台所提供的脚本', 'new' ); ?></p>
                </td>
            </tr>
            <tr>
                <td><label></label></td>
                <td></td>
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
        update_option( 'new_theme_about', wp_unslash( $new_theme_about ) );
        $new_theme_license = _filter_object_empty( $_REQUEST, 'new_theme_license', get_option( 'new_theme_license' ) );
        update_option( 'new_theme_license', wp_unslash( $new_theme_license ) );
        $new_theme_share = _filter_object_empty( $_REQUEST, 'new_theme_share', get_option( 'new_theme_share' ) );
        update_option( 'new_theme_share', wp_unslash( $new_theme_share ) );
        $new_theme_latest = _filter_object_empty( $_REQUEST, 'new_theme_latest', get_option( 'new_theme_latest' ) );
        update_option( 'new_theme_latest', wp_unslash( $new_theme_latest ) );
    }

    add_theme_page( 'new_theme_setting', __( '主题设置', 'new' ), 'manage_options', basename( __FILE__ ), 'new_theme_setting_admin' );
}
add_action( 'admin_menu', 'new_theme_setting_page' );
