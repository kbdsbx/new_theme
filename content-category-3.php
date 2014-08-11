<li>
    <a href="<?php the_permalink(); ?>"><img src="<?php echo new_get_thumbnail_src( 'xx' ); ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" /></a>
    <p>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_author() ?>   \\   <?php the_field( 'new-article-source' ); ?></span>
        <span class="rating" title="<?php the_field( 'new-article-views' ); ?>"><span style="width:<?php echo new_get_rating(); ?>%;"></span></span>
    </p>
    <br/>
    <p>
        <span><?php echo strip_tags( get_the_excerpt() ); ?></span>
    </p>
</li>

