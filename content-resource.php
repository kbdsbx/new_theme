<h4 class="center-block"><?php the_title(); ?></h4>
<div class="column-one-fourth">
    <ul class="block3">
    <li><?php _e( 'File Name: ', 'new' ); ?><span><?php the_title(); ?></span></li>
    <li><?php _e( 'Source Type: ', 'new' ); ?><span><?php echo get_field_object( 'type' )['choices'][ get_field( 'type' ) ]; ?></span></li>
    <li><?php _e( 'File Type: ', 'new' ); ?><span><?php echo get_field_object( 'type-' . get_field( 'type' ) )['choices'][ get_field( 'type-' . get_field( 'type' ) ) ]; ?></span></li>
    <li><?php _e( 'File Size: ', 'new' ); ?><span><?php the_field( 'size' ); ?></span></li>
    <li><?php _e( 'Upload Date: ', 'new' ); ?><span><?php the_time( get_option( 'date_format' ) ); ?></span></li>
    <li><?php _e( 'Download Count: ', 'new' ); ?><span><?php the_field( 'new-article-views' ); ?></span></li>
    </ul>
</div>
<div class="column-one-third">
    <div class="center-block">
        <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xs' )[0];?>" alt="<?php the_title(); ?> " width="300" height="162" />
    </div>
</div>
<div class="column-two-third">
<h5 class="line"><span><?php _e( 'Content', 'new' ); ?></span></h5>
<?php the_content(); ?>
</div>
<div class="column-two-third">
<h5 class="line"><span><?php _e( 'Download', 'new' ); ?></span></h5>
<a href="<?php echo wp_get_attachment_url( get_field( 'file' ) ); ?>" target="_blank"><?php _e( 'Download Address', 'new' ); ?></a>
</div>
