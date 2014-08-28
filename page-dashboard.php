<?php
/**
 * page dashboard template file.
 */
get_header( 'user' ) ?>

<?php
while( have_posts() ) {
    the_post();
    the_content();
}
?>

<?php get_footer( 'user' ); ?>
