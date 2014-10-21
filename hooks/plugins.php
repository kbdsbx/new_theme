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
 * wpuf
 */
function new_wpuf_filter_post_status( $show_status, $status ) {
    switch ( $status ) {
    case 'publish':
        $title = __( '已发布', 'new' );
        $fontcolor = "#33CC33";
        $icon = "icon-ok-circle";
        break;
    case 'draft':
        $title = __( '草稿', 'new' );
        $fontcolor = "#bbbbbb";
        $icon = "icon-file-alt";
        break;
    case 'pending':
        $title = __( '等待审核', 'new' );
        $fontcolor = "#C00202";
        $icon = "icon-question-sign";
        break;
    case 'future':
        $title = __( '定时发布', 'new' );
        $fontcolor = "#bbbbbb";
        $icon = "icon-time";
        break;
    case 'private':
        $title = __( '私人', 'new' );
        $fontcolor = "#bbbbbb";
        $icon = "icon-lock";
        break;
    }
    $show_status = '<span style="color:' . $fontcolor . ';"><i class="' . $icon . '"></i>&nbsp;&nbsp;' . $title . '</span>';
    return $show_status;
}
add_filter( 'wpuf_show_post_status', 'new_wpuf_filter_post_status', 10, 2 );

/**
 * 修改页面模板，未完成
 * TODO:
 */
function new_filter_page_template( $page ) {
    $pages = array(
        'dashboard',
        'add_new',
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

/* !plugins */
