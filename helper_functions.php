<?php

function mn_get_subscribers( $pagination = array() ) {
    global $wpdb;
    return $wpdb->get_results( "SELECT * FROM subscriber LIMIT {$pagination['start_sub']}, {$pagination['count_sub']}", ARRAY_A );
}

function mn_pagination() {
    global $wpdb;

    $current = 1;
    $count_sub = 3;
    $all_count_sub = $wpdb->get_var( "SELECT COUNT(id) FROM subscriber" );
    $count_page = ceil( $all_count_sub / $count_sub );

    if ( isset( $_GET['paged'] ) ) {
        if ( $_GET['paged'] > $count_page ) {
            $current = $count_page;
        } else {
            $current = $_GET['paged'];
        }
    }
    $start_sub = ( $current - 1 ) * $count_sub;

    return array(
        'count_sub' => $count_sub,
        'all_count_sub' => $all_count_sub,
        'count_page' => $count_page,
        'current' => $current,
        'start_sub' => $start_sub
    );
}


