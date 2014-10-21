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

/* !shortcode */
