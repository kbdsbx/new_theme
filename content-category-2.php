<li>
    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
    <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_author() ?>   \\   <?php the_field( 'new-article-source' ); ?></span>
    <span class="rating" title="<?php the_field( 'new-article-views' ); ?>"><span style="width:<?php echo ( ( get_field( 'new-article-views' ) / 350 ) > 1 ? 100 : ( get_field( 'new-article-views' ) / 3.5 ) ) ?>%;"></span></span>
</li>
