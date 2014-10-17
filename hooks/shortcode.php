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

/* !shortcode */
