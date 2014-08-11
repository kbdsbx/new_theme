<h4 class="center-block"><?php the_title(); ?></h4>
<div class="column-one-fourth">
    <ul class="block3">
    <li><?php _e( '文件名称: ', 'new' ); ?><span><?php the_title(); ?></span></li>
    <li><?php _e( '资源类型: ', 'new' ); ?><span><?php echo get_field_object( 'type' )['choices'][ get_field( 'type' ) ]; ?></span></li>
    <li><?php _e( '文件类型: ', 'new' ); ?><span><?php echo get_field_object( 'type-' . get_field( 'type' ) )['choices'][ get_field( 'type-' . get_field( 'type' ) ) ]; ?></span></li>
    <li><?php _e( '文件大小: ', 'new' ); ?><span><?php the_field( 'size' ); ?></span></li>
    <li><?php _e( '上传日期: ', 'new' ); ?><span><?php the_time( get_option( 'date_format' ) ); ?></span></li>
    <li><?php _e( '下载数量: ', 'new' ); ?><span><?php the_field( 'new-article-views' ); ?></span></li>
    </ul>
</div>
<div class="column-one-third">
    <div class="center-block">
        <img src="<?php echo new_get_thumbnail_src( 'xs' ) ?>" alt="<?php the_title(); ?> " width="300" height="162" />
    </div>
</div>
<div class="column-two-third">
<h5 class="line"><span><?php _e( '内容', 'new' ); ?></span></h5>
<?php the_content(); ?>
</div>
<div class="column-two-third">
<h5 class="line"><span><?php _e( '下载', 'new' ); ?></span></h5>
<a href="<?php echo wp_get_attachment_url( get_field( 'file' ) ); ?>" target="_blank"><?php _e( '下载地址', 'new' ); ?></a>
</div>
