<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
		<section class="slider">
            <div class="container">
				<?php dynamic_sidebar( 'sidebar-home-head' ); ?>
            </div>    
        </section>
        <!-- / Slider -->
        
        <!-- Content -->
        <section id="content">
            <div class="container">
            	<!-- Main Content -->

                <div class="main-content">
                <?php get_template_part( 'content', get_post_format() ); ?>	
                <?php dynamic_sidebar( 'sidebar-home-footer' ); ?> 
                </div>
                <!-- /Main Content -->
                <?php get_sidebar(); ?>
                
                <!-- Left Sidebar -->
                <div class="column-one-third">
                    <div class="sidebar">
                    	<h5 class="line"><span>漫步西国</span></h5>
                        <ul class="ads125">
							{dede:arclist  row=8 typeid='22' titlelen=20 flag ='p' orderby='pubdate' }
							<li><a href="[field:arcurl/]"><img src="[field:litpic/]" alt="[field:title/]" /></a></li>
							{/dede:arclist}
                        </ul>
                    </div>
                    <div class="sidebar">
                    	<h5 class="line"><span>线下西语</span></h5>
                        <div id="accordion">
                        	{dede:arclist typeid=7 row=6 titlelen=30 infolen=200 orderby='typeid'}
	                            <h3>[field:title/]</h3>
	                            <div>
	                                <p><a href="[field:arcurl/]" class="title">[field:info/]</a></p>
	                            </div>
                        	{/dede:arclist}
                        </div>
                    </div>
                </div>
                <!-- /Left Sidebar -->
                
            </div>    
        </section>
		<!-- / Content -->

<?php get_footer(); ?>
