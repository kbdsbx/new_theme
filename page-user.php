<?php
/**
 * template file of edit page.
 */
get_header( 'user' ) ?>

<div class="main-content">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="icon-home home-icon"></i><?php _e( '主页', 'new' ); ?></li>
            <li class="active"><?php the_title(); ?></li>
        </ul>
        <div class="nav-search" id="nav-search">
			<form class="form-search">
				<span class="input-icon">
                    <input type="text" placeholder="<?php _e( '搜索', 'new' ); ?>" class="nav-search-input" id="nav-search-input" autocomplete="off">
					<i class="icon-search nav-search-icon"></i>
				</span>
			</form>
		</div>
    </div>
    <div class="page-content">
        <div class="page-header">
            <h1><?php the_title(); ?></h1>
        </div>
        <div class="row">
            <div class="col-xs-12">
<?php
while( have_posts() ) {
    the_post();
    the_content();
}
?>
            </div>
        </div>
    </div>
</div>

<?php get_footer( 'user' ); ?>
