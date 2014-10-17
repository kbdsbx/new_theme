<?php

/* seo */

/**
 * 处理bloginfo，使之显示更多有利于SEO的相关信息
 */
function new_filter_bloginfo( $bloginfo, $keyword ) {
    switch ( $keyword ) {
    case 'description':
        if ( is_category() ) {
            $category = get_category( get_query_var( 'cat' ), false );
            if ( ! empty( $category ) ) {
                $bloginfo = $category->category_description;
            } 
        } else if ( is_tag() ) {
            $tag = get_tag( get_query_var( 'tag' ), false );
            if ( ! empty ( $category ) ) {
                $bloginfo = $tag->description;
            }
        } else if ( is_single() || is_page() ) {
            $bloginfo = get_the_excerpt();
        }
        return $bloginfo;
    case 'keyword':
        if ( is_single() ) {
            $tags = get_the_tags();
            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    $bloginfo .= ',' . $tag->name;
                }
            }
        }
        return $bloginfo;
    default:
        return $bloginfo;
    }
}
add_filter( 'bloginfo', 'new_filter_bloginfo', 10, 2 );

/**
 * 对网站title添加网站名称，利于SEO
 */
function new_filter_title_parts( $title ) {
    if ( is_category() ) {
    } else if ( is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            foreach ( $categories as $category ) {
                $title[] = $category->name;
            }
        }
    }
    $title[] = get_bloginfo( 'name' );
    return $title;
}
add_filter( 'wp_title_parts', 'new_filter_title_parts', 10, 2 );

/**
 * 对网站title添加网站URL，利于SEO
 */
function new_filter_title( $title ) {
    return $title . get_bloginfo( 'url' );
}
add_filter( 'wp_title', 'new_filter_title' );

/* !seo */
