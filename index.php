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
		<section id="slider">
            <div class="container">
				<?php dynamic_sidebar('sidebar-flexslider'); ?>
                <!--div class="main-slider">
                	<div class="badg">
                    	<p><a href="#">hot.</a></p>
                    </div>
                	<div class="flexslider">
                        <ul class="slides">
							{dede:arclist flag='f' titlelen=40 infolen=120 row='5'}
                            <li>
                            	<input hidden="hidden" id="[field:global.autoindex/]" />
                                <a href="[field:arcurl/]"><img src="[field:litpic/]" alt="MyPassion" width="540" height="372" /></a>
                                <p class="flex-caption"><a href="[field:arcurl/]">[field:title function='html2text(@me)'/]</a>[field:info /]...</p>
                            </li>
							{/dede:arclist}
                        </ul>
                    </div>
                </div-->
                
                <div class="slider2">
                	<div id="tabs">
                        <ul>
                            <li><a href="#tabs1">排行</a></li>
                            <li><a href="#tabs2">推荐</a></li>
                            <li><a href="#tabs3">随机</a></li>
                        </ul>
                        <div id="tabs1">
                            <ul>
								{dede:arclist row=4 titlelen=30 orderby='click' }
	                            	<li>
	                                	<a href="[field:arcurl/]" class="title">[field:title/]</a>
	                                    <span class="meta">[field:sortrank function=GetDateMk(@me) /]   \\   [field:writer /]   \\   [field:source /]</span>
	                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
	                                </li>
								{/dede:arclist}
                            </ul>
                        </div>
                        <div id="tabs2">
                            <ul>
								{dede:arclist  row=4 titlelen=30 typeid='' flag ='c'  orderby='pubdate' }
	                            	<li>
	                                	<a href="[field:arcurl/]" class="title">[field:title/]</a>
	                                    <span class="meta">[field:sortrank function=GetDateMk(@me) /]   \\   [field:writer /]   \\   [field:source /]</span>
	                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
	                                </li>
								{/dede:arclist}
                            </ul>
                        </div>
                        <div id="tabs3">
                            <ul>
								{dede:arclist  row=4 titlelen=30 typeid='' orderby='rand' }
	                            	<li>
	                                	<a href="[field:arcurl/]" class="title">[field:title/]</a>
	                                    <span class="meta">[field:sortrank function=GetDateMk(@me) /]   \\   [field:writer /]   \\   [field:source /]</span>
	                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
	                                </li>
								{/dede:arclist}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>    
        </section>
        <!-- / Slider -->
        
        <!-- Content -->
        <section id="content">
            <div class="container">
            	<!-- Main Content -->
                <div class="main-content">
                	
                    <!-- Todays -->
                	<div class="column-one-third">
                    	<h5 class="line"><span>今日更新</span></h5>
                        <div class="outertight">
                        	<ul class="block">
							{dede:arclist row=4 titlelen=20 orderby='pubdate' }
                                <li>
                                    <a href="[field:arcurl/]"><img src="[field:litpic/]" alt="[field:title/]" class="alignleft" width="140" height="86" /></a>
                                    <p>
                                        <a href="[field:arcurl/]">[field:title/]</a>
                                        <span>[field:sortrank function=GetDateMk(@me) /]</span>
                                    </p>
                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
                                </li>
							{/dede:arclist}
                            </ul>
                        </div>
                        
                    </div>
                    <!-- /Todays -->
                    
                    <!-- Hot -->
                    <div class="column-one-third">
                    	<h5 class="line"><span>最新活动</span></h5>
                        <div class="outertight m-r-no">
                        	<ul class="block">
								{dede:arclist typeid=31 row=4 titlelen=20 orderby='pubdate' }
	                                <li>
	                                    <a href="[field:arcurl/]"><img src="[field:litpic/]" alt="[field:title/]" class="alignleft" width="140" height="86" /></a>
	                                    <p>
	                                        <a href="[field:arcurl/]">[field:title/]</a>
	                                        <span>[field:sortrank function=GetDateMk(@me) /]</span>
	                                    </p>
	                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
	                                </li>
								{/dede:arclist}
                            </ul>
                        </div>
                        
                    </div>
                    <!-- /Hot -->
                    
                    <!-- Teachers -->
                    <div class="column-two-third">
                    	<h5 class="line">
                        	<span>优秀教师</span>
                            <div class="navbar">
                                <a id="next1" class="next" href="#"><span></span></a>	
                                <a id="prev1" class="prev" href="#"><span></span></a>
                            </div>
                        </h5>
                        
                        <div class="outertight">
                        	{dede:arclist row=1 idlist="49" titlelen=40 infolen=200 } 
	                        	<img src="[field:litpic /]" alt="[field:title /]" width="300" height="162" />
	                            <h6 class="regular"><a href="[field:arcurl /]">[field:title /]</a></h6>
	                            <p>[field:info /]</p>
							{/dede:arclist}
                        </div>
                        
                        <div class="outertight m-r-no">
                        	
                        	<ul class="block" id="carousel">
								{dede:arclist row=8 titlelen=20 infolen=48 flag ='c' typeid='14' orderby='pubdate' }
									<li>
	                                    <a href="[field:arcurl/]"><img src="[field:litpic/]" alt="[field:title/]" class="alignleft" width="140" height="86" /></a>
	                                    <p>
	                                        <a href="[field:arcurl/]">[field:title/]</a>
	                                    </p>
	                                    <p>[field:info/]...</p>
	                                </li>
								{/dede:arclist}
                            </ul>
                        </div>
                    </div>
                    <!-- /Teachers -->
                    
                    <!-- Spanish -->
                	<div class="column-two-third">
                    	<div class="outertight">
                        	<h5 class="line"><span>西语天地</span></h5>
                            
                            <div class="outertight m-r-no">
	                            <ul class="block">
									{dede:arclist row=4 typeid='15' titlelen=30 orderby='click' }
		                            	<li>
		                                	<a href="[field:arcurl/]" class="title">[field:title/]</a>
		                                    <span class="meta">[field:sortrank function=GetDateMk(@me)/]   \\   [field:writer/]   \\   [field:source/]</span>
		                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
		                                </li>
									{/dede:arclist}
	                            </ul>
	                        </div>
                        </div>
                        
                        <div class="outertight m-r-no">
                        	<h5 class="line"><span>西语资源</span></h5>
                            
                            <div class="outertight m-r-no">
	                            <ul class="block">
									{dede:arclist row=4 typeid='49' titlelen=30 orderby='click' }
		                            	<li>
		                                	<a href="[field:arcurl/]" class="title">[field:title/]</a>
		                                    <span class="meta">[field:sortrank function=GetDateMk(@me) /]   \\   [field:writer /]   \\   [field:source /]</span>
		                                    <span class="rating"><span style="width:[field:click function="((@me / 350) > 1 ? 100 : @me / 350 * 100)" /]%;"></span></span>
		                                </li>
									{/dede:arclist}
	                            </ul>
	                        </div>
                        </div>
                    </div>
                    <!-- /Spanish -->
                    
	                <div class="column-two-third">
	                    <h5 class="line"><span>友情链接</span></h5>
	                    <ul class="block4">
	                        {dede:flink row='24'/}
	                    </ul>
	                </div>
                </div>
                <!-- /Main Content -->
                
                <!-- Left Sidebar -->
                <div class="column-one-third">
                	{dede:include filename="attention.htm"/}
                    <div class="sidebar">
                        <img title="阿根廷两所国立大学指定培训机构" alt="阿根廷两所国立大学指定培训机构" src="{dede:global.cfg_cmsurl/}/images/tdldzd.png"></img>
                    </div>
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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
