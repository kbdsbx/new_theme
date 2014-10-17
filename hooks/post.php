<?php

/* post */

/**
 * 文章默认属性计算，累计及赋值
 */
function set_post_views() {
    global $post;
    if ( ! isset ( $post->ID ) )
        return;

    if ( is_singular() ) {
        if ( isset( $post->ID ) ) {
            $new_post_options = get_post_meta( $post->ID, 'new_post_options', true );
            if ( $new_post_options ) {
                $new_post_options['new_post_view_count'] = $new_post_options['new_post_view_count'] + 1;
                update_post_meta( $post->ID, 'new_post_options', $new_post_options );
            }
        }
    }

    if ( is_admin() ) {
        if ( isset( $post->ID ) ) {
            $new_post_options = get_post_meta( $post->ID, 'new_post_options', true );
            if ( $new_post_options && isset( $new_post_options['new_post_view_count'] ) && $new_post_options['new_post_view_count'] == 0 ) {
                $new_post_options['new_post_view_count'] = rand( 0, _filter_empty_numeric( get_option( 'new_theme_heat_limit' ) ) );
                update_post_meta( $post->ID, 'new_post_options', $new_post_options );
            }
        }
    }
}
add_action('wp_head', 'set_post_views'); 
add_action('save_post', 'set_post_views'); 

/**
 * 添加文章主循环中文章类型字段以保证分页时不会由于找不到文件而返回404
 */
function new_filter_request( $query_vars ) {
    global $post_types_keys;
    if ( ! is_admin() && isset( $query_vars['paged'] ) && isset( $query_vars['category_name'] ) ) {
        $query_vars['post_type'] = $post_types_keys;
    }
    return $query_vars;
}
add_filter( 'request', 'new_filter_request' );

/**
 * 文章针对不同文章类型的模板筛选
 */
function new_filter_single_template( $template_path ) {
    global $post;
    $post_type = $post->post_type;
    $template = get_template_directory() . '/single-' . $post_type . '.php';
    if ( $post_type != 'post' && file_exists( $template ) ) {
        $template_path = $template;
    }
    return $template_path;
}
add_filter( 'single_template', 'new_filter_single_template' );

/**
 * 为标记为加粗的文章设置粗体
 */
function new_filter_the_title( $title, $id = null ) {
    if ( ! is_admin() ) {
        $flags = _filter_array_empty_array( get_post_meta( $id, 'new_post_options', true ), 'new_post_flags' );
        if ( array_search( 'bold', $flags) !== false ) {
            $title = '<strong>' . $title . '</strong>';
        }
    }
    return $title;
}
add_filter( 'the_title', 'new_filter_the_title', 10, 2 );

/**
 * 针对中文链接与文章采集防范所设置的固定链接更改
 * 使用Unix时间戳防止相同标题导致相同固定链接
 */
function new_filter_permalink( $link ) {
    if ( preg_match( "/(^[0-9]+$)|([\x80-\xff])/", $link ) )
        return CUtf8_PY::encode( $link, '', 'head' ) . date( 'ymdhis', time() );
    else
        return $link;
}
add_filter( 'editable_slug', 'new_filter_permalink' );

/* !post */
