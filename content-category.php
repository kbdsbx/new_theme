<li>
    <a href="<?php the_permalink(); ?>"><img src="<?php echo new_get_thumbnail_src( 'xx' ); ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" /></a>
    <p>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
        <span class="rating" title="<?php the_field( 'new-article-views' ); ?>"><span style="width:<?php echo new_get_rating(); ?>%;"></span></span>
    </p>
</li>
