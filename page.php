<?php
/**
 * The page template file
 */
get_header(); ?>
<section id="content">
    <div class="container">
        <div class="breadcrumbs column">
            <?php if ( function_exists( 'bcn_display' ) ) : bcn_display(); endif; ?>
        </div>
        <div class="column">
<?php
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
