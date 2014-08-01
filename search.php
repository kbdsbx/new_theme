<?php
/**
 * The search template file.
 */
get_header(); ?>

<section id="content">
    <div class="container">
        <div class="breadcrumbs column">
            <?php if( function_exists( 'bcn_display' ) ) : bcn_display(); endif; ?>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="column-two-third">
	            <?php if ( have_posts() ) : ?>
	            <h5 class="line"><?php printf( __( 'Number of Results: %s.', 'new' ), $wp_query->found_posts ); ?></h5>
	            <ul class="block">
	<?php while (have_posts()) : the_post(); ?>
	<?php get_template_part( 'content', 'category-3' ); ?>
	<?php endwhile; ?>
	            </ul>
	            <?php else : ?>
	            <h5 class="line"><?php printf( __( 'Nothing found.', 'new' ), $wp_query->found_posts ); ?></h5>
	            <?php _e( 'Sorry, nothing matched your search keyword. please try again with some different keywords.', 'new' ); ?>
	            <?php endif; ?>
                <div class="pager">
                <?php wp_pagenavi(); ?>
                </div>
            </div>
        </div>
        <!-- /Main Content -->
        <?php get_sidebar( 'category' ); ?>
    </div>
</section>

<?php get_footer(); ?>
