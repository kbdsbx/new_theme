<?php

class WP_Widget_flink extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_flink', 'description' => __( '再您的页面上显示友情链接', 'new' ) );
        parent::__construct( 'flink', __( '友情链接', 'new' ), $widget_ops );
    }

    function _sort( $a, $b ) {
        $args = $this->callback_args; 
        if ( $a[$args['orderby']] == $b[$args['orderby']] ) return 0;
        return $a[$args['orderby']] > $b[$args['orderby']] ? 1 : -1;
    }

    function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', _filter_array_empty( $instance, 'title', __( '友情链接', 'new' ) ), $instance, $this->id_base );
        $count      = _filter_array_empty( $instance, 'flink_count', 64 );
        $orderby    = _filter_array_empty( $instance, 'orderby', 'link_name' );

        $this->callback_args = array(
            'orderby'   => $orderby
        );

        $flink_data = _filter_empty_array( get_option( 'flink_data' ), array() );
        // 使用指定的属性排序
        usort( $flink_data, array( $this, '_sort' ) );
        array_splice( $flink_data, $count );

        echo $args[ 'before_widget' ];
?>
<h5 class="line"><span><?php echo $title; ?></span></h5>
<ul class="block4">
    <?php foreach ( $flink_data as $link ) : ?>
    <?php if ( $link['link_status'] ) : ?>
    <li><a href="<?php echo $link['link_url']; ?>" target="_blank"><?php echo $link['link_name']; ?></a></li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul>
<?php
        echo $args[ 'after_widget' ];
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']          = _filter_empty( $new_instance['title'], '' );
        $instance['flink_count']    = _filter_empty_numeric( $new_instance['flink_count'], 64 );
        $instance['orderby']        = _filter_empty( $new_instance['orderby'], 'link_name' );

        return $instance;
    }


    function form( $instance ) {
        $title          = esc_attr( _filter_array_empty( $instance, 'title', '' ) );
        $flink_count    = esc_attr( _filter_array_empty( $instance, 'flink_count', '' ) );
        $orderby        = esc_attr( _filter_array_empty( $instance, 'orderby', '' ) );
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( '标题:', 'new' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( '排序:', 'new' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <option value=""><?php _e( '&mdash; 选择 &mdash;', 'new' ) ?></option>
                <option <?php echo $orderby == 'link_name' ? 'selected="selected"' : ''; ?> value="link_name"><?php _e( '名称', 'new' ); ?></option>
                <option <?php echo $orderby == 'link_url' ? 'selected="selected"' : ''; ?> value="link_url"><?php _e( 'URL', 'new' ); ?></option>
                <option <?php echo $orderby == 'link_date' ? 'selected="selected"' : ''; ?> value="link_date"><?php _e( '添加时间', 'new' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('flink_count'); ?>"><?php _e( '显示友链数量:', 'new' ); ?></label>
            <input type="text" value="<?php echo $flink_count; ?>" name="<?php echo $this->get_field_name( 'flink_count' ); ?>" id="<?php echo $this->get_field_id('flink_count'); ?>" size="3" />
        </p>
<?php
    }
}
register_widget( 'WP_Widget_flink' );
