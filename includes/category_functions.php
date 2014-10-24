<?php

/**
 * 分类目录
 */

/**
 * 获取分类目录
 *
 * @param array $args 详见http://codex.wordpress.org/Function_Reference/get_categories
 */
function new_get_categories( $args = array() ) {
    $categories = get_categories( $args );
    $category_options = _filter_empty_array( get_option( 'category_options' ) );
    foreach ( $categories as &$category ) {
        $category_option = _filter_array_empty_array( $category_options, $category->term_id );
        if ( isset( $category_options[ $category->term_id ] ) ) {
            $category->new_post_type = _filter_array_empty( $category_option, 'new_post_type' );
            $category->new_post_submission = _filter_array_empty( $category_option, 'new_post_submission' );
        }
    }
    return $categories;
}

