<?php
/**
 * The searchform template file.
*/
global $wp_query;
?>
<div class="search-form">
    <form action="<?php echo esc_url( home_url( '/' ) );?>" method="get" >
		<input name="s" id="s" type="text" placeholder="<?php _e( '搜索', 'new' ); ?>" value="<?php echo _filter_object_empty( $wp_query->query, 's', '' ); ?>" class="ft"/>
        <input type="submit" value="" class="fs">
    </form>
</div>
