<?php

function add_subscribers() {

    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce ) ) {
        wp_send_json( array( 'error' => true, 'msg' => 'danger!' ) );
    }

    parse_str( $_POST['params'], $params );

    $mn_email = ( ! empty( $params['mn_email'] ) ) ? esc_sql( $params['mn_email'] ) : null;
    $mn_name = ( ! empty( $params['mn_name'] ) ) ? esc_sql( $params['mn_name'] ) : null;

    if ( ! $mn_email ) {
        wp_send_json( array( 'error' => true, 'msg' => 'danger2' ) );
    }

    global $wpdb;

    $res = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM subscriber WHERE email = %s", $mn_email ) );

    if ( $res) {
        wp_send_json( array( 'error' => true, 'msg' => 'Такий вже є!' ) );
    } else {
        $res_insert = $wpdb->query( $wpdb->prepare( "INSERT INTO subscriber ( name, email ) VALUES ( %s, %s )", $mn_name, $mn_email ) );
        if ( $res_insert ) {
            wp_send_json( array( 'error' => false, 'msg' => 'ok' ) );
        } else {
            wp_send_json( array( 'error' => true, 'msg' => 'no' ) );
        }
    }
}
add_action( 'wp_ajax_add_subscribers', 'add_subscribers' );
add_action( 'wp_ajax_no_priv_add_subscribers', 'add_subscribers' );

function tm_send_sub() {
    sleep(2);
    session_start();
    parse_str( $_POST['params'], $params );

    if ( key_exists( $_SESSION['pool'], $params['params'] ) ) {
        unset( $params['params'][ $_SESSION['pool'] ] );
    }

    if ( ! empty( $params['params'] ) ) {
        foreach ( $params as $key => $param ) {
            $_SESSION['pool'] = $key;
            wp_send_json( array( 'params' => $params['params'] ) );
        }
    } else {
        unset( $_SESSION['pool'] );
        wp_send_json( false );
    }
}
add_action( 'wp_ajax_tm_send_sub', 'tm_send_sub' );
