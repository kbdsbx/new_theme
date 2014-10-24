<?php

/* plugins */

/**
 * 过滤某些页面不需要的样式表
 */
function new_filter_styles() {
    if ( is_home()
      || is_preview()
      || is_archive()
      || is_attachment()
      || is_author()
      || is_category()
      || is_search()
      || is_single()
      || is_tag()
      || is_404() ) {
        // front-end-pm
        wp_dequeue_style( 'fep-style' );
        // user-frontend-pro
        wp_dequeue_style( 'wpuf-css' );
        wp_dequeue_style( 'wpuf-chosen-style' );
        // wp-pagenavi
        wp_dequeue_style( 'wp-pagenavi' );
        // paid-memberships-pro
        wp_dequeue_style( 'pmpro_frontend' );
        wp_dequeue_style( 'pmpro_print' );
        wp_dequeue_style( 'pmpro_frontend_rtl' );
    }
}
add_action( 'wp_print_styles', 'new_filter_styles', 100 );

/**
 * 过滤某些页面不需要的脚本文件
 */
function new_filter_scripts() {
    if ( is_home()
      || is_preview()
      || is_archive()
      || is_attachment()
      || is_author()
      || is_category()
      || is_search()
      || is_single()
      || is_tag()
      || is_404() ) {
        // front-end-pm
        wp_dequeue_script( 'fep-script' );
        // user-frontend-pro
        wp_dequeue_script( 'wpuf-chosen' );
        wp_dequeue_script( 'wpuf-form' );
        wp_dequeue_script( 'wpuf-conditional-logic' );
        wp_dequeue_script( 'wpuf-subscriptions' );
        wp_dequeue_script( 'jquery-ui-datepicker' );
        wp_dequeue_script( 'jquery-ui-autocomplete' );
        wp_dequeue_script( 'suggest' );
        wp_dequeue_script( 'jquery-ui-slider' );
        wp_dequeue_script( 'plupload-handlers' );
        wp_dequeue_script( 'jquery-ui-timepicker' );
        wp_dequeue_script( 'wpuf-upload' );
        wp_dequeue_script( 'wpuf-form' );
        wp_dequeue_script( 'wpuf-upload' );
        // paid-membership-pro
        wp_dequeue_script( 'ssmemberships_js' );
    }
}
add_action( 'wp_print_scripts', 'new_filter_scripts', 100 );

/**
 * 修改页面模板，未完成
 * TODO:
 */
function new_filter_page_template( $page ) {
    $pages = array(
        'dashboard',
        'post_add',
        'edit',
        'favourite',
        'pm',
        'info',
        'account',
        'membership-account',
        'membership-billing',
        'membership-cancel',
        'membership-checkout',
        'membership-confirmation',
        'membership-invoice',
        'membership-levels',
        'protected-content',
        'reigster'
    );
    if ( is_page( $pages ) ) {
        $new_template = locate_template( array( 'page-user.php' ) );
        return _filter_empty( $new_template, $page );
    }
    return $page;
}
add_filter( 'template_include', 'new_filter_page_template' );

/**
 * 仅更改私人会话（站内信）会员头像
 */
function new_filter_get_avatar( $avatar ) {
    if ( ! empty( $avatar ) && is_page( 'pm' ) ) {
        return str_replace( 'photo', 'photo pull-left', $avatar );
    }
    return $avatar;
}
add_filter( 'get_avatar', 'new_filter_get_avatar' );

/**
 * 添加Login信息
 *
 * @author: 萨龙龙
 * @url: http://yfdxs.com/login-interface-two.html
 */
function new_login_body_class( $classes ) {
    $classes[] = 'custom-background';
    return $classes;
}
add_action('login_body_class', 'new_login_body_class');
/**
 * 添加Login样式
 *
 * @author: 萨龙龙
 * @url: http://yfdxs.com/login-interface-two.html
 */
function new_login_head() {
    wp_enqueue_style( 'new-login', new_template_uri . '/css/member/login.css', array(), null );
    _custom_background_cb();
}
add_action( 'login_head', 'new_login_head' );

/**
 * 修改Logo链接
 *
 * @author: 胡倡萌
 * @url: http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
add_filter( 'login_headerurl', create_function( false, "return home_url( '/' );" ) );

/**
 * 添加注册表单字段
 */
function new_register_form() {
?>
<p>
    <label for="pass1"><?php _e( '密码', 'new' ); ?><br />
	<input type="password" name="new_password" id="pass1" class="input" value="" size="20" /></label>
</p>
<p>
    <label for="pass2"><?php _e( '再次输入密码', 'new' ); ?><br />
	<input type="password" name="new_password2" id="pass2" class="input" value="" size="20" /></label>
</p>
<p>
    <div id="pass-strength-result"><?php _e('Strength indicator'); ?></div>
</p>
<p>
    <label for="user_url"><?php _e( '网站', 'new' ); ?><br />
    <input type="url" name="new_user_url" id="user_url" class="input" value="" size="20" /></label>
</p>
<?php wp_print_scripts( 'user-profile' ); ?>
<?php
}
add_action( 'register_form', 'new_register_form' );

/**
 * 添加注册错误信息
 */
function new_registration_errors( $errors ) {
    if ( empty( $_POST['new_password'] ) || empty( $_POST['new_password2'] ) ) {
        $errors->add( 'empty_password', __( '<strong>错误</strong>：密码不能为空', 'new' ) );
    } else if ( $_POST['new_password'] != $_POST['new_password2'] ) {
        $errors->add( 'invalid_password', __( '<strong>错误</strong>：再次输入密码不匹配', 'new' ) );
    }
    return $errors;
}
add_filter( 'registration_errors', 'new_registration_errors' );

/**
 * 添加注册信息更新
 */
function new_user_register( $user_id ) {
    $userdata = array(
        'ID' => $user_id
    );
    if ( isset( $_POST['new_user_url'] ) ) {
        $userdata['user_url'] = $_POST['new_user_url'];
    }
    wp_update_user( $userdata );
}
add_filter( 'user_register', 'new_user_register' );

/**
 * 当存在密码提交时，随机密码使用提交的密码
 */
function new_random_password( $password ) {
    if ( isset( $_POST['new_password'] ) && isset( $_POST['new_password2'] ) && $_POST['new_password'] == $_POST['new_password2'] ) {
        return $_POST['new_password'];
    }
    return $password;
}
add_filter( 'random_password', 'new_random_password' );

/**
 * 跳转
 */
function new_login_redirect( $redirect_to, $requested_redirect_to, $user ) {
    if ( !is_wp_error( $user ) && $user->has_cap( 'manage_options' ) ) {
        return $redirect_to ? $redirect_to : admin_url();
    } else {
        return ( $redirect_to && $redirect_to != admin_url() ) ? $redirect_to : _filter_empty( new_get_page_link_by_slug( 'dashboard' ), home_url( '/' ) );
    }
}
add_filter( 'login_redirect', 'new_login_redirect', 10, 3 );

/* !plugins */
