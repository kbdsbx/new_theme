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
    $w = _filter_array_empty_numeric( get_post_meta( get_the_ID(), 'new_post_options', true ), 'new_post_view_count', 0 ) / _filter_empty_numeric( get_option( 'new_theme_heat_limit' ), 400 );
    $w = $w > 1 ? 100 : $w * 100;
    return $w;
}

/**
 * 获取文章来源
 * in the loop
 */
function new_get_source() {
    return _filter_array_empty( get_post_meta( get_the_ID(), 'new_post_options', true ), 'new_post_source', __( '未知来源', 'new' ) );
}

/**
 * 获取文章浏览量
 * in the loop
 */
function new_get_view_count() {
    return _filter_array_empty_numeric( get_post_meta( get_the_ID(), 'new_post_options', true ), 'new_post_view_count', 0 );
}

/**
 * 获取资源字段
 * in the loop of resource
 */
function new_get_resource_field( $field ) {
    switch ( $field ) {
    case 'new_resource_type':
        $file_type = @file_get_contents( new_expand . '/file_type.json' );
        $field_value = _filter_array_empty( get_post_meta( get_the_ID(), 'new_resource_options', true ), $field, '' );
        if ( ! empty( $file_type ) && ! empty( $field_value ) ) {
            $file_type = json_decode( $file_type );
            foreach( $file_type as $type ) {
                if ( $type->id == $field_value ) {
                    return $type->name;
                }
            }
        }
        return __( '未知资源类型', 'new' );
    case 'new_resource_file_type':
        $file_type = @file_get_contents( new_expand . '/file_type.json' );
        $field_value = _filter_array_empty( get_post_meta( get_the_ID(), 'new_resource_options', true ), $field, '' );
        if ( ! empty( $file_type ) && ! empty( $field_value ) ) {
            $file_types = json_decode( $file_type );
            foreach( $file_types as $type ) {
                if ( ! empty ( $type->children ) ) {
                    foreach( $type->children as $file_type ) {
                        if ( $file_type->id == $field_value ) {
                            return $file_type->name;
                        }
                    }
                }
            }
        }
        return __( '未知文件类型', 'new' );
        break;
    default:
        return _filter_array_empty( get_post_meta( get_the_ID(), 'new_resource_options', true ), $field, '' );
    }
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
    $modules_data = _filter_empty_array( get_option( 'modules_data' ) );
    if ( is_array( $modules_data ) && function_exists( '_new_sort_modules' ) ) {
        usort( $modules_data, '_new_sort_modules' );
        $modules_data = array_filter( $modules_data, '_new_filter_modules' );
    }
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

