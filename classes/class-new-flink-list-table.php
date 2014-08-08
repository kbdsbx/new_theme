<?php
# @charset=utf-8

require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

class NEW_Flink_List_Table extends WP_List_Table {
    function __construct( $args = array() ) {
        parent::__construct( array(
            'plural' => 'flinks',
            'singular' => 'flink',
            'screen' => false,
            'ajax' => true,
        ) );
    }

    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'link_name'     => __( '友链名称', 'new' ),
            'link_url'      => __( '友链链接', 'new' ),
            'link_date'     => __( '添加时间', 'new' ),
            'link_status'   => __( '友链状态', 'new' )
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
        foreach ( $v as $bs ) {
            if ( strstr( $bs, $args['search'] ) !== false ) return true;
        } 
    }

    function get_items() {
        $args = $this->callback_args;
        $flink_data = _filter_empty( get_option( 'flink_data' ), array() );

        foreach ( $flink_data as $f => $link ) {
            $flink_data[$f]['link_date_str'] = date( 'Y-m-d', $link['link_date'] );
        }
    
        return empty( $args[ 'search' ] ) ? $flink_data : array_filter( $flink_data, array( $this, "_filter" ) );
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
            return date( 'Y-m-d', $item[$column_name] );
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
        $paged = isset( $paged ) ? intval( $paged ) : 1;
        $search = !empty( $_REQUEST['s'] ) ? trim( wp_unslash( $_REQUEST['s'] ) ) : '';
        
        $args = array(
            'search'    => $search,
            'page'      => 10,
            'number'    => $paged
        );

        $this->callback_args = $args;

        $columns = $this->get_columns();
        $this->_column_headers = array( $columns, array(), array() );
        $this->set_pagination_args( array (
            'total_items' => $this->get_items_count(),
            'per_page' => 20,
            'total_pages' => $paged
        ) );
        $this->items = $this->get_items();
    }
}

?>
