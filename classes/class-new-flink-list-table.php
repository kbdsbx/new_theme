<?php
# @charset=utf-8

require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

class NEW_Flink_List_Table extends WP_List_Table {
    function __construct( $args = array() ) {
        parent::__construct( array(
            'plural' => 'flinks',
            'singular' => 'flink',
            'screen' => 'flink',
            'ajax' => true,
        ) );
    }

    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'link_name'     => __( '名称', 'new' ),
            'link_url'      => __( '链接', 'new' ),
            'link_date'     => __( '添加时间', 'new' ),
            'link_status'   => __( '状态', 'new' )
        );

        return $columns;
    }

    function get_sortable_columns() {
        $columns = array(
            'link_name'     => 'link_name',
            'link_url'      => 'link_url', 
            'link_date'     => 'link_date',
            'link_status'   => 'link_status'
        );

        return $columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete'        => __( '删除', 'new' ),
            'disabled'      => __( '禁用', 'new' ),
            'enabled'       => __( '启用', 'new' ),
        );

        return $actions;
    }

    function _filter( $v ) {
        $args = $this->callback_args;
        $search = $args['search'];
        foreach ( $v as $bs ) {
            if ( strstr( $bs, $search ) !== false || $bs == $search ) return true;
        } 
    }

    function _sort( $a, $b ) {
        $args = $this->callback_args;
        $orderby = $args['orderby'];
        $order = strtoupper( $args['order'] ) === 'ASC' ? 1 : -1;

        if ( $a[$orderby] > $b[$orderby] ) return $order;
        else if ( $a[$orderby] < $b[$orderby] ) return 0 - $order;
        else return 0;
    }

    function get_items() {
        $args = $this->callback_args;
        $flink_data = _filter_empty( get_option( 'flink_data' ), array() );

        foreach ( $flink_data as $f => $link ) {
            $flink_data[$f]['link_date_str'] = date( get_option( 'date_format' ), $link['link_date'] );
        }

        if ( !empty( $args['search'] ) )
            $flink_data = array_filter( $flink_data, array( $this, '_filter' ) );

        if ( isset( $args['orderby'] ) && isset( $args['order'] ) )
            usort( $flink_data, array( $this, '_sort' ) );

        return $flink_data;
    }

    function get_items_count() {
        return count( $this->get_items() );
    }

    function has_items() {
        return $this->get_items_count() !== 0;
    }

    function column_default( $item, $column_name ) {
        switch ( $column_name ) {
        case 'link_date' :
            return date( get_option( 'date_format' ), $item[$column_name] );
        case 'link_status' :
            switch( $item[$column_name] ) {
            case '1' :
                return __( '启用', 'new' );
            case '0' :
                return __( '禁用', 'new' );
            }
        default :
            return $item[$column_name];
        }
    }

    function column_cb( $item ) {
        $value = $item['link_name'];
        return sprintf( '<input type="checkbox" name="%1$s[]" id="%2$s" value="%3$s" />', $this->_args['singular'], $value, $value );
    }

    function prepare_items() {
        $paged = $this->get_items_per_page( 'flink_per_page' );

        $args = array(
            'page'      => $this->get_pagenum(),
            'number'    => $paged
        );

        if ( isset( $_REQUEST['s'] ) )
            $args['search'] = trim( wp_unslash( $_REQUEST['s'] ) );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
			$args['orderby'] = trim( wp_unslash( $_REQUEST['orderby'] ) );
            $args['order'] = trim( wp_unslash( $_REQUEST['order'] ) );
        }

        $this->callback_args = $args;

        $this->set_pagination_args( array(
            'total_items' => $this->get_items_count(),
            'per_page' => $paged,
        ) );

        $this->items = $this->get_items();
    }
}

?>
