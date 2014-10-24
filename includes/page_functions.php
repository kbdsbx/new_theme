<?php

/* page functions */

/**
 * 格式显示文章类型
 *
 * @param string $status 文章状态
 */
function new_filter_post_status( $status ) {
    switch ( $status ) {
    case 'publish':
        $title = __( '已发布', 'new' );
        $fontcolor = "#33CC33";
        $icon = "icon-ok-circle";
        break;
    case 'draft':
        $title = __( '草稿', 'new' );
        $fontcolor = "#BBBBBB";
        $icon = "icon-file-alt";
        break;
    case 'pending':
        $title = __( '等待审核', 'new' );
        $fontcolor = "#C00202";
        $icon = "icon-question-sign";
        break;
    case 'future':
        $title = __( '定时发布', 'new' );
        $fontcolor = "#BBBBBB";
        $icon = "icon-time";
        break;
    case 'private':
        $title = __( '私人', 'new' );
        $fontcolor = "#BBBBBB";
        $icon = "icon-lock";
        break;
    case 'trash':
        $title = __( '已删除', 'new' );
        $fontcolor = "#DD5A43";
        $icon = "icon-trash";
        break;
    }
    $show_status = '<span style="color:' . $fontcolor . ';"><i class="' . $icon . '"></i>&nbsp;&nbsp;' . $title . '</span>';
    return $show_status;
}

function new_get_edit_link( $post_id ) {
    $edit_page = get_posts( array( 'pagename' => 'new_edit', 'post_type' => 'page' ) );

    if ( ! empty( $edit_page ) ) {
        $post_edit_url = get_permalink( $edit_page[0]->ID ) . '?post_id=' . $post_id;
    } else {
        $post_edit_url = get_edit_post_link( $post_id );
    }
    return $post_edit_url;
}

/**
 * 通过页面别名获取页面
 *
 * @param string $slug 页面别名
 */
function new_get_page_by_slug( $slug ) {
    $edit_page = get_posts( array( 'pagename' => $slug, 'post_type' => 'page' ) );

    return _filter_array_empty( $edit_page, 0, false );
}

/**
 * 通过页面别名获取页面链接
 *
 * @param string $slug 页面别名
 */
function new_get_page_link_by_slug( $slug ) {
    $edit_page = new_get_page_by_slug( $slug );

    return ( $edit_page !== false ? get_permalink( $edit_page->ID ) : false );
}

/* !page functions */
