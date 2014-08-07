<li>
    <a href="<?php the_permalink(); ?>"><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xx' ) [0]; ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" /></a>
    <p>
        <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
        <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_field( 'size' ); ?>   \\   <?php echo get_field_object( 'type' )['choices'][ get_field( 'type' ) ]; ?></span>
        <span class="rating" title="<?php the_field( 'new-article-views' ); ?>"><span style="width:<?php echo ( ( get_field( 'new-article-views' ) / 350 ) > 1 ? 100 : ( get_field( 'new-article-views' ) / 3.5 ) ) ?>%;"></span></span>
    </p>
    <br/>
    <p><?php echo strip_tags( get_the_excerpt() ); ?></p>
</li>
