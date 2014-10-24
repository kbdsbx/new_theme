<?php

/* shortcode */

/**
 * 修改图片集显示方式
 */
function new_shortcode_gallery( $atts ) {
    $atts = shortcode_atts( array(
        'link'  => '',
        'ids'   => '',
        'size'  => 'md',
    ), $atts );
    $ids = explode( ',', $atts['ids'] );
?>
<div class="flexslider">
    <ul class="slides">
<?php foreach( $ids as $id ) : ?>
        <li><?php echo wp_get_attachment_image( $id, $atts['size'] ); ?></li>
<?php endforeach; ?>
    </ul>
</div>
<?php
}
add_shortcode( 'gallery', 'new_shortcode_gallery' );

/**
 * 收藏列表页面
 */
function new_shortcode_new_favourite( $atts ) {
    $atts = shortcode_atts( array(), $atts );
    $user_id = get_current_user_id();
    if ( $user_id != 0 ) {
        $user_favourite = _filter_empty_array( get_user_meta( $user_id, 'new_favourite_posts' , true ) );
?>
<ul class="item-list" id="favourite_list">
    <?php if ( empty( $user_favourite ) ) : ?>
    <li>
        <div class="well well-sm"><?php _e( '收藏列表为空', 'new' ); ?></div>
    </li>
    <?php else : ?>
    <?php foreach ( $user_favourite as $post_id ) : ?>
    <li class="item-default clearfix" id="favourite_<?php echo $post_id; ?>">
        <div class="pull-left action-buttons">
            <a class="load-click pointer red" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-target="#favourite_<?php echo $post_id; ?>" data-dtype="JSON" data-action="new_favourite" data-opt="cancel" data-post_id="<?php echo $post_id; ?>"><i class="icon-trash bigger-130"></i></a>
        </div>
        <label class="inline"><span class="lbl"><a href="<?php echo get_permalink( $post_id ); ?>" target="_blank" title="<?php echo get_the_title( $post_id ); ?>"><?php echo get_the_title( $post_id ); ?></a></span></label>
    </li>
    <?php endforeach; ?>
    <li class="item-red clearfix">
        <a class="btn btn-xs btn-danger load-click" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-target="#favourite_list" data-dtype="JSON" data-action="new_favourite" data-opt="clear" target="_blank">
            <i class="icon-trash bigger-110"></i>
            <span class="bigger-110 no-text-shadow"><?php _e( '清空收藏夹', 'new' ); ?></span>
        </a>
    </li>
    <?php endif; ?>
</ul>
<?php
    } else {
?>
    <span><?php printf( __( '未登录用户无法访问此页面，请<a href="%s">登录</a>后再试', 'new' ), home_url( 'wp-login.php' ) ); ?></span>
<?php
    }
}
add_shortcode( 'new_favourite', 'new_shortcode_new_favourite' );

/**
 * 用户中心首页
 */
function new_shortcode_new_dashboard() {
    global $post_types, $post_types_keys, $paged, $post;
    $user_id = get_current_user_id();
    if ( $user_id == 0 ) {
?>
    <span><?php printf( __( '未登录用户无法访问此页面，请<a href="%s">登录</a>后再试', 'new' ), home_url( 'wp-login.php' ) ); ?></span>
<?php
        return;
    }
    // 计算不同文章类型的文章总和
    $count_user_posts = 0;
    foreach( $post_types_keys as $post_type ) {
        $count_user_posts += _filter_array_empty_numeric( count_many_users_posts( array( $user_id ), $post_type ), 1 );
    }
    $posts = query_posts( array(
        'posts_per_page'    => _filter_empty_numeric( get_option( 'posts_per_page' ) ),
        'offset'            => ( _filter_empty_numeric( get_query_var( 'paged' ), 1 ) - 1 ) * _filter_empty_numeric( get_option( 'posts_per_page' ) ),
        'post_type'         => $post_types_keys,
        'author'            => $user_id
    ) );
    // $paged = _filter_empty_numeric( get_query_var( 'paged' ), 1 );
?>
<div class="infobox infobox-green">
    <div class="infobox-icon">
	    <i class="icon-file-alt"></i>
	</div>

    <div class="infobox-data">
        <span class="infobox-data-number"><?php echo $count_user_posts; ?></span>
        <div class="infobox-content"><?php _e( '文章', 'new' ); ?></div>
    </div>
</div>
                
<div class="infobox infobox-blue">
	<div class="infobox-icon">
		<i class="icon-comments"></i>
	</div>

	<div class="infobox-data">
        <span class="infobox-data-number">0</span>
        <div class="infobox-content"><?php _e( '评论', 'new' ); ?></div>
    </div>
</div>
<div class="space-6"></div>
<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?php _e( '标题', 'new' ); ?></th>
                <th><?php _e( '类型', 'new' ); ?></th>
                <th><?php _e( '状态', 'new' ); ?></th>
                <th><?php _e( '评论', 'new' ); ?></th>
                <th><?php _e( '选项', 'new' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                <tr>
                    <td>
                        <a href="<?php echo get_permalink( get_the_ID() ); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </td>
                    <td>
                        <?php echo $post_types[ $post->post_type ]; ?>
                    </td>
                    <td>
                        <?php echo new_filter_post_status( $post->post_status ); ?>
                    </td>
                    <td>
                        <?php echo $post->comment_count; ?>
                    </td>
                    <td>
                        <a href="<?php echo new_get_edit_link( get_the_ID() ); ?>"><i class="icon-edit"></i>&nbsp;<?php _e( '编辑', 'new' ); ?></a>
                        <a href="<?php echo get_delete_post_link( get_the_ID() ); ?>" onclick="return confirm( '<?php _e( '要删除这篇文章吗？', 'new' ); ?>' );"><span class="red"><i class="icon-trash"></i>&nbsp;删除</span></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">
                        <?php _e( '没有您的文章', 'new' ); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-12">
            <div class="dataTables_paginate paging_bootstrap">
                <?php echo new_pagenavi( 5, array( 'ul_class' => 'pagination', 'active_class' => 'active' ) ); ?>
            </div>
        </div>
    </div>
</div>
<?php
    wp_reset_query();
}
add_shortcode( 'new_dashboard', 'new_shortcode_new_dashboard' );

function new_shortcode_post_add() {
    global $post_types_keys, $post_types;
    $categories = new_get_categories();
    $categories_group = array();
    foreach( $post_types_keys as $post_type ) {
        $categories_group[ $post_type ] = array();
        foreach ( $categories as $category ) {
            if ( _filter_object_empty( $category, 'new_post_type' ) == $post_type ) {
                $categories_group[ $post_type ][] = $category;
            }
        }
    }
?>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php _e( '标题', 'new' ); ?></label>
        <div class="col-sm-9">
            <input type="text" id="title" name="title" placeholder="" class="col-xs-10 col-sm-5">
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php _e( '文章来源', 'new' ); ?></label>
        <div class="col-sm-9">
            <input type="url" id="source" name="source" placeholder="<?php echo __( '例如：', 'new' ) . home_url( '/' ); ?>" class="col-xs-10 col-sm-5">
            <span class="help-inline col-xs-12 col-sm-7">
                <span class="middle"><?php _e( '非转载、分享、搬运可留空', 'new' ); ?></span>
			</span>
		</div>

    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php _e( '分类目录', 'new' ); ?></label>
        <div class="col-sm-9">
            <select class="col-xs-10 col-sm-5" id="category" name="category" >
            <?php foreach( $categories_group as $key => $categories ) : ?>
                <optgroup label="<?php echo $post_types[ $key ]; ?>">
                <?php foreach( $categories as $category ) : ?>
                    <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
            </select>
        </div>
    </div>
    <style>
.acefix *,
.acefix *:before,
.acefix *:after {
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
}
.wp-editor-container {
    border: 1px solid #e5e5e5;
}
.screen-reader-text {
    display: none;
}
    </style>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php _e( '内容', 'new' ); ?></label>
        <div class="col-sm-7 acefix">
            <!-- div class="wysiwyg-editor" id="content"></div -->
            <?php wp_editor( '', 'content', array( 'textarea_rows' => 10 ) ); ?>
            <div class="hr hr-double dotted"></div>
            <!-- script> window.onload = function() { $('#content').ace_wysiwyg(); } </script -->
        </div>
    </div>
</form>
<?php
    wp_enqueue_style( 'media-views' );
}
add_shortcode( 'new_post_add', 'new_shortcode_post_add' );

/* !shortcode */
