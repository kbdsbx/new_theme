<?php

if ( ! function_exists ( '_filter_empty' ) ) {

    function _filter_empty( $obj, $def = null ) {
        return empty( $obj ) ? $def : $obj;
    }

}

if ( ! function_exists ( '_filter_empty_array' ) ) {

    function _filter_empty_array( $obj, $def = array() ) {
        return is_array( $obj ) ? _filter_empty( $obj, $def ) : $def; 
    }

}
if ( ! function_exists ( '_filter_empty_numeric' ) ) {

    function _filter_empty_numeric( $obj, $def = 0 ) {
        return is_numeric( $obj ) ? _filter_empty( $obj, $def ) : $def;
    }

}
if ( ! function_exists ( '_filter_object_empty' ) ) {

    function _filter_object_empty( $obj, $param, $def = null ) {
        return isset( $obj[ $param ] ) ? _filter_empty( $obj[ $param ], $def ) : $def;
    }

}
if ( ! function_exists ( '_filter_object_empty_array' ) ) {

    function _filter_object_empty_array( $obj, $param, $def = array() ) {
        return isset( $obj[ $param ] ) ? _filter_empty_array( $obj[ $param ], $def ) : $def;
    }

}
if ( ! function_exists ( '_filter_object_empty_numeric' ) ) {

    function _filter_object_empty_numeric( $obj, $param, $def = 0 ) {
        return isset( $obj[ $param ] ) ? _filter_empty_numeric( $obj[ $param ], $def ) : $def;
    }

}
