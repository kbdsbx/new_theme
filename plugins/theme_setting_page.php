<?php

function new_theme_setting_admin() {
?>
<div class="wrap">
    <h2><?php _e( '其他设置', 'new' ); ?></h2>
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="new_theme_about"><?php _e( '关于', 'new' ); ?></label></th>
                <td>
                    <fieldset>
                        <textarea name="new_theme_about" rows="10" cols="35" id="new_theme_about" class="large-text code"><?php form_option( 'new_theme_about' ); ?></textarea>
                        <p><?php _e( '显示主页脚部关于', 'new' ); ?></p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="new_theme_license"><?php _e( '声明', 'new' ); ?></label></th>
                <td>
                    <fieldset>
                        <textarea name="new_theme_license" rows="3" cols="35" id="new_theme_license" class="large-text code"><?php form_option( 'new_theme_license' ); ?></textarea>
                        <p><?php _e( '显示关于本网站的声明', 'new' ); ?></p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="new_theme_share"><?php _e( '分享', 'new' ); ?></label></th>
                <td>
                    <fieldset>
                        <textarea name="new_theme_share" rows="10" cols="35" id="new_theme_share" class="large-text code"><?php form_option( 'new_theme_share' ); ?></textarea>
                        <p><?php _e( '每一篇文章中显示的分享脚本', 'new' ); ?></p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="new_theme_latest"><?php _e( '最新动态', 'new' ); ?></label></th>
                <td>
                    <fieldset>
                        <textarea name="new_theme_latest" rows="10" cols="35" id="new_theme_latest" class="large-text code"><?php form_option( 'new_theme_latest' ); ?></textarea>
                        <p><?php _e( '在脚部中显示的个人或企业最新动态，使用第三方社交平台所提供的脚本', 'new' ); ?></p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="new_theme_default_thumbnail_id"><?php _e( '默认缩略图', 'new' ); ?></label></th>
                <td>
                    <fieldset>
                        <input name="new_theme_default_thumbnail_id" id="new_theme_default_thumbnail_id" type="hidden" value="<?php form_option( 'new_theme_default_thumbnail_id' ); ?>" />
                        <a class="button choose-from-library-link"
				        data-update-url="<?php echo get_admin_url() . 'admin-ajax.php'; ?>"
				        data-update-action="img_widget_update"
	                    data-update-preview=".preview_src"
				        data-update-preview-src="#new_theme_default_thumbnail_id"
				        data-choose="<?php _e( '请选择默认缩略图', 'new' ); ?>"
				        data-update="<?php _e( '选择缩略图', 'new' ); ?>"><?php _e( '选择缩略图', 'new' ); ?></a>
                        <img class="preview_src" src="<?php $default_thumbnail_id = get_option( 'new_theme_default_thumbnail_id' ); if ( ! empty( $default_thumbnail_id ) ) echo new_get_image_src( $default_thumbnail_id ); ?>" />
                        <?php _img_widget_update_js(); ?>
                        <p><?php _e( '当文章未添加缩略图时显示此缩略图', 'new' ); ?></p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="new_theme_heat_limit"><?php _e( '文章访问量', 'new' ); ?></label></th>
                <td>
                    <fieldset>
                        <input name="new_theme_heat_limit" id="new_theme_heat_limit" type="text" value="<?php form_option( 'new_theme_heat_limit' ); ?>" />
                        <p><?php _e( '创建的文章将从( 0 ~ 此量 )中随机抽取一个数作为文章的访问量', 'new' ); ?></p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for=""></label></th>
                <td>
                    <fieldset>
                    </fieldset>
                </td>
            </tr>
        </table>
        <input type="hidden" name="action" value="new_theme_edit" />
        <?php submit_button(); ?>
    </form>
</div>
<?php
}

function new_theme_setting_page() {
    if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'new_theme_edit' ) {
        $new_theme_about = _filter_object_empty( $_REQUEST, 'new_theme_about', '' );
        update_option( 'new_theme_about', wp_unslash( $new_theme_about ) );
        $new_theme_license = _filter_object_empty( $_REQUEST, 'new_theme_license', '' );
        update_option( 'new_theme_license', wp_unslash( $new_theme_license ) );
        $new_theme_share = _filter_object_empty( $_REQUEST, 'new_theme_share', '' );
        update_option( 'new_theme_share', wp_unslash( $new_theme_share ) );
        $new_theme_latest = _filter_object_empty( $_REQUEST, 'new_theme_latest', '' );
        update_option( 'new_theme_latest', wp_unslash( $new_theme_latest ) );
        $new_theme_default_thumbnail_id = _filter_object_empty_numeric( $_REQUEST, 'new_theme_default_thumbnail_id', '' );
        update_option( 'new_theme_default_thumbnail_id', $new_theme_default_thumbnail_id );
        $new_theme_heat_limit = _filter_object_empty_numeric( $_REQUEST, 'new_theme_heat_limit', '' );
        update_option( 'new_theme_heat_limit', $new_theme_heat_limit );
    }

    add_options_page( 'new_theme_setting', __( '主题设置', 'new' ), 'manage_options', basename( __FILE__ ), 'new_theme_setting_admin' );
}
add_action( 'admin_menu', 'new_theme_setting_page' );
