<?php
/**
 * The category template file
 */
get_header(); ?>
<section id="content">
    <div class="container">
        <div class="breadcrumbs column">
        <?php echo new_breadcrumbs(); ?>
        </div>
        <div class="main-content">
            <!-- Popular News -->	
            <div class="column-two-third">
                <div class="outerwide">
                    <ul class="block2">
<?php
global $wp_query, $post_types_keys;
query_posts( array_merge( $wp_query->query_vars, array( 'post_type' => $post_types_keys ) ) );
while ( have_posts() ) : the_post();
    get_template_part( 'content', 'category-it' );
endwhile;
?>
                    </ul>
                </div>
                <div class="pager">
                    <?php echo new_pagenavi(); ?>
                </div>
            </div>
            <!-- /Popular News -->
        </div>
        <?php get_sidebar( 'category' ); ?>
    </div>
</section>

<?php get_footer();?>
