<?php

class WP_Widget_Tabs extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_tabs', 'description' => __( '显示推荐文章，点击排序与随机文章', 'new' ) );

        parent::__construct('tabs', __( '切换控件', 'new' ), $widget_ops);
	}

	function widget( $args, $instance ) {
        global $post_types_keys;
		$title      = apply_filters( 'widget_title', _filter_empty( $instance['title'], __( '切换控件', 'new' ), $instance, $this->id_base ) );
		$posts_per_page = _filter_empty_numeric( $instance['posts_per_page'], 4 );

		$args_rank = array(
            'posts_per_page'=> $posts_per_page,
			'orderby'		=> 'meta_value_num',
            'meta_key'      => 'new-article-views',
            'post_type'     => $post_types_keys,
            'cat'           => _get_cat()
		);
		$args_recommend = array(
            'posts_per_page'=> $posts_per_page,
            'meta_query'    => array( array( 'key' => 'new-article-flags', 'value' => 'recommend', 'compare' => 'LIKE' ) ),
			'orderby'		=> 'date',
            'post_type'     => $post_types_keys,
            'cat'           => _get_cat()
		);
		$args_random = array(
            'posts_per_page'=> $posts_per_page,
			'orderby'		=> 'rand',
            'post_type'     => $post_types_keys,
            'cat'           => _get_cat()
		);

		echo $args['before_widget'];
?>
	<div id="new-tabs">
        <ul>
			<li><a href="#new-tabs1"><?php _e( '热门', 'new' ); ?></a></li>
            <li><a href="#new-tabs2"><?php _e( '推荐', 'new' ); ?></a></li>
            <li><a href="#new-tabs3"><?php _e( '随机', 'new' ); ?></a></li>
        </ul>
        <div id="new-tabs1">
            <ul>
<?php
				$query = new WP_Query( $args_rank );
			 	while( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'content', 'category-td' );
                endwhile;
                wp_reset_query();
?>
            </ul>
        </div>
        <div id="new-tabs2">
            <ul>
<?php
				$query = new WP_Query( $args_recommend );
			 	while( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'content', 'category-td' );
                endwhile;
                wp_reset_query();
?>
            </ul>
        </div>
        <div id="new-tabs3">
            <ul>
<?php
				$query = new WP_Query( $args_random );
			 	while( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'content', 'category-td' );
                endwhile;
                wp_reset_query();
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
		$title = esc_attr( _filter_array_empty( $instance, 'title', '' ) );
        $posts_per_page = esc_attr( _filter_array_empty( $instance, 'posts_per_page', '' ) );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( '标题:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e( '文章数量:', 'new' ); ?></label>
			<input type="text" value="<?php echo $posts_per_page; ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" id="<?php echo $this->get_field_id('posts_per_page'); ?>" size="3" />
		</p>
<?php
	}
}
register_widget('WP_Widget_Tabs');

