<?php

class WP_Widget_Tabs extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_tabs', 'description' => __( 'The tabs of posts and incoding ranks, recommends, randoms.', 'new' ) );

        parent::__construct('tabs', __( 'Tabs', 'new' ), $widget_ops);
	}

	function widget( $args, $instance ) {

		$title      = apply_filters( 'widget_title', _filter_empty( $instance['title'], __( 'Ads Pictures', 'new' ), $instance, $this->id_base ) );

		$posts_per_page = _filter_empty_numeric( $instance['posts_per_page'], 4 );

		$args_rank = array(
            'posts_per_page'=> $posts_per_page,
            'page'          => 1,
			'order'			=> 'DESC',
			'meta_key'		=> 'views',
			'orderby'		=> 'meta_value_num'
		);
		$args_recommend = array(
            'posts_per_page'=> $posts_per_page,
            'page'          => 1,
			'order'			=> 'DESC',
			'meta_key'		=> '_new_meta_article_recommend',
			'meta_value'	=> 'true',
			'orderby'		=> 'post_date'
		);
		$args_random = array(
            'posts_per_page'=> $posts_per_page,
            'page'          => 1,
			'order'			=> 'DESC',
			'orderby'		=> 'rand'
		);

        if ( is_category() ) {
            $cat = get_cat_ID( single_cat_title( '', false ) );
        } else if ( is_single() ) {
            $category = get_the_category();
            $cat = $category[0]->cat_ID;
        }
        if ( ! empty( $cat ) ) {
            $args_rank[ 'cat' ] = $cat;
            $args_recommend[ 'cat' ] = $cat;
            $args_random[ 'cat' ] = $cat;
        }

		echo $args['before_widget'];
?>
	<div id="tabs">
        <ul>
			<li><a href="#tabs1"><?php _e( 'Rank', 'new' ); ?></a></li>
            <li><a href="#tabs2"><?php _e( 'Recommend', 'new' ); ?></a></li>
            <li><a href="#tabs3"><?php _e( 'Random', 'new' ); ?></a></li>
        </ul>
        <div id="tabs1">
            <ul>
<?php
				$query = new WP_Query( $args_rank );
			 	while( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'content', 'category-2' );
                endwhile;
?>
            </ul>
        </div>
        <div id="tabs2">
            <ul>
<?php
				$query = new WP_Query( $args_recommend );
			 	while( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'content', 'category-2' );
                endwhile;
?>
            </ul>
        </div>
        <div id="tabs3">
            <ul>
<?php
				$query = new WP_Query( $args_random );
			 	while( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'content', 'category-2' );
                endwhile;
?>
            </ul>
        </div>
    </div>

<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']          = _filter_empty( $new_instance['title'], $old_instance['title'] );
        $instance['posts_per_page'] = _filter_empty_numeric( $new_instance['posts_per_page'], $old_instance['posts_per_page'] );

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = esc_attr( _filter_object_empty( $instance, 'title', '' ) );
        $posts_per_page = esc_attr( _filter_object_empty( $instance, 'posts_per_page', '' ) );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e( 'Post count:', 'new' ); ?></label>
			<input type="text" value="<?php echo $posts_per_page; ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" id="<?php echo $this->get_field_id('posts_per_page'); ?>" size="3" />
		</p>
<?php
	}
}
register_widget('WP_Widget_Tabs');

