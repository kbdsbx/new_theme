<h4 class="center-block"><?php the_title(); ?></h4>
<div class="column-one-fourth">
    <ul class="block3">
    <li><?php _e( '文件名称: ', 'new' ); ?><span><?php the_title(); ?></span></li>
    <li><?php _e( '资源类型: ', 'new' ); ?><span><?php echo new_get_resource_field( 'new_resource_type' ); ?></span></li>
    <li><?php _e( '文件类型: ', 'new' ); ?><span><?php echo new_get_resource_field( 'new_resource_file_type' ); ?></span></li>
    <li><?php _e( '文件大小: ', 'new' ); ?><span><?php echo new_get_resource_field( 'new_resource_file_size' ); ?></span></li>
    <li><?php _e( '上传日期: ', 'new' ); ?><span><?php the_time( get_option( 'date_format' ) ); ?></span></li>
    <li><?php _e( '下载数量: ', 'new' ); ?><span><?php echo new_get_view_count(); ?></span></li>
    <li><?php if ( function_exists( 'wpfp_link' ) ) { wpfp_link(); } ?></li>
    </ul>
</div>
<div class="column-one-third">
    <div class="center-block">
        <img src="<?php echo new_get_thumbnail_src( 'xs' ) ?>" alt="<?php echo new_get_thumbnail_alt(); ?>" title="<?php echo new_get_thumbnail_alt(); ?>" width="300" height="162" />
    </div>
</div>
<div class="column-two-third">
<h5 class="line"><span><?php _e( '内容', 'new' ); ?></span></h5>
<?php the_content(); ?>
</div>
<div class="column-two-third">
<h5 class="line"><span><?php _e( '下载', 'new' ); ?></span></h5>
<a href="<?php echo wp_get_attachment_url( new_get_resource_field( 'new_resource_file' ) ); ?>" target="_blank"><?php _e( '下载地址', 'new' ); ?></a>
</div>
