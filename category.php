<?php
/**
 * The category template file
 */
get_header(); ?>
<section id="content">
    <div class="container">
        <div class="breadcrumbs column">
        <?php if( function_exists( 'bcn_display' ) ) : bcn_display(); endif; ?>
        </div>
        <div class="main-content">
            <!-- Popular News -->	
            <div class="column-two-third">
                <div class="outerwide">
                    <ul class="block2">
<?php
while ( have_posts() ) : the_post();
    get_template_part( 'content', 'category' );
endwhile;
?>
                    </ul>
                </div>
                <div class="pager">
                    <?php wp_pagenavi(); ?>
                </div>
            </div>
            <!-- /Popular News -->
        </div>
        <?php get_sidebar( 'category' ); ?>
    </div>
</section>

<?php get_footer();?>
