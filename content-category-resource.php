<li>
    <a href="<?php the_permalink(); ?>"><img src="<?php echo new_get_thumbnail_src( 'xx' ); ?>" alt="<?php echo new_get_thumbnail_alt(); ?>" title="<?php echo new_get_thumbnail_alt(); ?>" class="alignleft" width="140" height="86" /></a>
    <p>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php echo new_get_resource_field( 'new_resource_file_size' ); ?>   \\   <?php echo new_get_resource_field( 'new_resource_type' ); ?></span>
        <span class="rating" title="<?php echo new_get_view_count(); ?>"><span style="width:<?php echo new_get_rating(); ?>%;"></span></span>
    </p>
    <br/>
    <p><?php echo strip_tags( get_the_excerpt() ); ?></p>
</li>
