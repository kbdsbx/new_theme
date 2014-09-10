<?php


/* other function */

/**
 * 获取缩略图链接（若存在）或使用主题默认缩略图
 * in the loop
 */
function new_get_thumbnail_src( $size ) {
    return wp_get_attachment_image_src( '' == get_post_thumbnail_id() ? get_option( 'new_theme_default_thumbnail_id' ) : get_post_thumbnail_id(), $size )[0]; 
}

/**
 * 获取缩略图提示
 * in the loop
 */
function new_get_thumbnail_alt() {
    return strip_tags( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) );
}

/**
 * 获取文章热度
 * in the loop
 */
function new_get_rating() {
    $w = get_field( 'new-article-views' ) / _filter_empty_numeric( get_option( 'new_theme_heat_limit' ), 400 );
    $w = $w > 1 ? 100 : $w * 100;
    return $w;
}

/**
 * in the loop
 */
function new_get_time() {
    $date_format = get_option( 'date_format' );

}

/**
 * 获取并解析图片集短代码
 */
function new_get_gallery_shortcode() {
    $content = get_the_content();
    $matches = array();
    $count = preg_match( '/(\[gallery[\s\S]+?\])/', $content, $matches );
    if ( $count !== 0 ) {
        $shortcode = $matches[0];
        if ( strpos( $shortcode, 'size' ) === false ) {
            $shortcode = str_replace( 'gallery', 'gallery size="xs"', $shortcode );
        }
        do_shortcode( $shortcode );
    }
}

/**
 * 内部排序方法
 */
function _new_sort_modules( $a, $b ) {
    if ( $a['module_weight'] < $b['module_weight'] ) return -1; 
    elseif ( $a['module_weight'] > $b['module_weight'] ) return 1; 
    else return 0;
}
/**
 * 内部筛选方法
 */
function _new_filter_modules( $v ) {
    if ( $v['module_status'] == 0 ) return false;
    else return true;
}
/**
 * 模块排序
 */
function new_modules() {
    $modules_data = get_option( 'modules_data' );
    usort( $modules_data, '_new_sort_modules' );
    $modules_data = array_filter( $modules_data, '_new_filter_modules' );
    return $modules_data;
}
/**
 * 模块获取
 *
 * @param string $id 模块ID
 */
function new_get_module( $id ) {
    $modules_data = get_option( 'modules_data' );
    foreach ( $modules_data as $module ) {
        if ( $module['module_id'] == $id )
            return $module;
    }
    return false;
}

/* !other function */

