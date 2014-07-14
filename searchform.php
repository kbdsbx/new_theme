<?php
/**
 * The searchform template file.
 * @package MineZine
 * @since MineZine 1.0.0
*/
?>
<form action="<?php echo esc_url( home_url( 'search' ) );?>" method="post">
	<input type="text" placeholder="<?php _e( 'Search', 'new' ); ?>" class="ft"/>
	<input type="submit" value="" class="fs">
</form>
