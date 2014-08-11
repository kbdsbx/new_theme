<?php
# @charset=utf-8

require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

class NEW_Modules_List_Table extends WP_List_Table {
    function __construct( $args = array() ) {
        parent::__construct( array(
            'plural' => 'modules',
            'singular' => 'module',
            'screen' => false,
            'ajax' => true,
        ) );
    }

    function get_columns() {
        $columns = array(
            'cb'                => '<input type="checkbox" />',
            'module_name'       => __( '名称', 'new' ),
            'module_category'   => __( '分类', 'new' ),
            'module_post_count' => __( '文章数量', 'new' ),
            'module_type'       => __( '显示类型', 'new' ),
            'module_status'     => __( '状态', 'new' ),
            'module_date'       => __( '添加时间', 'new' ),
            'module_weight'     => __( '权重', 'new' ),
        );

        return $columns;
    }

    function get_sortable_columns() {
        $columns = array(
            'module_name'       => 'module_name',
            'module_category'   => 'module_category',
            'module_post_count' => 'module_post_count',
            'module_type'       => 'module_type',
            'module_status'     => 'module_status',
            'module_date'       => 'module_date',
            'module_weight'     => 'module_weight',
        );
    }

    function get_bulk_actions() {
        $actions = array(
            'delete'        => __( '删除', 'new' ),
            'disabled'      => __( '禁用', 'new' ),
            'enabled'       => __( '启用', 'new' )
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
        $modules_data = _filter_empty( get_option( 'modules_data' ), array() );

        foreach( $modules_data as $m => $data ) {
            $modules_data[$m]['modules_date_str'] = date( get_option( 'date_format' ), $data['module_date'] );
        }

        return empty( $args['search'] ) ? $modules_data : array_filter( $modules_data, array( $this, '_filter' ) );
    }

    function get_items_count() {
        return count( $this->get_items() );
    }

    function has_items() {
        return $this->get_items_count() !== 0;
    }

    function column_default( $item, $column_name ) {
        global $new_module_type;
        switch( $column_name ) {
        case 'module_date' :
            return date( get_option( 'date_format' ), $item[$column_name] );
        case 'module_status' :
            switch( $item[$column_name] ) {
            case '1' :
                return __( '启用', 'new' );
            case '0' :
                return __( '禁用', 'new' );
            default :
                return '';
            }
        case 'module_category' :
            $cat = $item[$column_name];
            switch ( $cat ) {
            case '0' :
                return __( '全部', 'new' );
            default :
                return get_the_category_by_ID( $cat );
            }
        case 'module_type' :
            return $new_module_type[$item[$column_name]];
        default :
            return $item[$column_name];
        }
    }

    function column_cb( $item ) {
        $value = $item['module_name'];
        return sprintf( '<input type="checkbox" name="%1$s[]" id="%2$s" value="%3$s" />', $this->_args['singular'], $value, $value );
    }

    function prepare_items() {
        $paged = isset( $paged ) ? intval( $paged ) : 1;
        $search = !empty( $_REQUEST['s'] ) ? trim( wp_unslash( $_REQUEST['s'] ) ) : '';

        $args = array(
            'search'    => $search,
            'page'      => 10,
            'number'    =>$paged
        );

        $this->callback_args = $args;

        $columns = $this->get_columns();
        $this->_column_headers = array( $columns ,array(), array() );
        $this->set_pagination_args( array(
            'total_items' => $this->get_items_count(),
            'per_page' => 20,
            'total_pages' => $paged
        ) );
        $this->items = $this->get_items();
    }
}

?>
