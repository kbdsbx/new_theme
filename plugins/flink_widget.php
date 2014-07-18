<?php

class WP_Widget_flink extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_flink', 'description' => __( 'Friend links in the main page.' ) );
        parent::__construct( 'flink', __( 'Friend links' ), $widget_ops );
    }

    function _sort( $a, $b ) {
        $args = $this->callback_args; 
        if ( $a[$args['orderby']] == $b[$args['orderby']] ) return 0;
        return $a[$args['orderby']] > $b[$args['orderby']] ? 1 : -1;
    }

    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Friend links' ) : $instance['title'], $instance, $this->id_base );
        $count = empty( $instance['flink_count'] ) ? 64 : $instance['flink_count'];
        $orderby = empty ( $instance['orderby'] ) ? 'link_name' : $instance['orderby'];

        $this->callback_args = array(
            'orderby'   => $orderby
        );

        $flink_data = get_option( 'flink_data' );
        usort( $flink_data, array( $this, '_sort' ) );
        array_splice( $flink_data, $count );
        echo $before_widget;
?>
<div class="main-content">
    <div class="column-two-third">
        <h5 class="line"><span><?php _e( 'Friend links', 'new' ); ?></span></h5>
	    <ul class="block4">
            <?php foreach ( $flink_data as $link ) : ?>
            <li><a href="<?php echo $link['link_url']; ?>" target="_blank"><?php echo $link['link_name']; ?></a></li>
            <?php endforeach; ?>
	    </ul>
	</div>
</div>
<?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = !empty( $new_instance['title'] ) ? $new_instance['title'] : '';
        $instance['flink_count'] = ( !empty( $new_instance['flink_count'] ) && is_numeric( $new_instance['flink_count'] ) ) ? $new_instance['flink_count'] : 64;
        $instance['orderby'] = $new_instance['orderby'] ? $new_instance['orderby'] : '';

        return $instance;
    }


    function form( $instance ) {
        $title = esc_attr( $instance['title'] );
        $flink_count = esc_attr( $instance['flink_count'] );
        $orderby = esc_attr( $instance['orderby'] );
?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( 'Order by:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <option value=""><?php _e( '&mdash; Select &mdash;' ) ?></option>
                <option <?php echo $orderby == 'link_name' ? 'selected="selected"' : ''; ?> value="link_name"><?php _e( 'Name', 'new' ); ?></option>
                <option <?php echo $orderby == 'link_url' ? 'selected="selected"' : ''; ?> value="link_url"><?php _e( 'Url', 'new' ); ?></option>
                <option <?php echo $orderby == 'link_date' ? 'selected="selected"' : ''; ?> value="link_date"><?php _e( 'Date', 'new' ); ?></option>
            </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('flink_count'); ?>"><?php _e( 'Friend links count:' ); ?></label>
			<input type="text" value="<?php echo $flink_count; ?>" name="<?php echo $this->get_field_name('flink_count'); ?>" id="<?php echo $this->get_field_id('flink_count'); ?>" size="3" />
		</p>
<?php
    }
}
register_widget( 'WP_Widget_flink' );
