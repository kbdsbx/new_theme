<li>
    <a href="<?php the_permalink(); ?>"><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xx' )[0]; ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" /></a>
    <p>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_author() ?></span>
        <span class="rating"><span style="width:<?php echo ( ( get_post_views() / 350 ) > 1 ? 100 : ( get_post_views() / 3.5 ) ) ?>%;"></span></span>
    </p>
</li>
