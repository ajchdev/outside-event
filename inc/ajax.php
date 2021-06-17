<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package Outside Event Ajax
 * @version 1.0.0
*/

add_action('wp_ajax_outside_event_event_filter', 'outside_event_event_filter');
add_action('wp_ajax_nopriv_outside_event_event_filter', 'outside_event_event_filter');

if( !function_exists( 'outside_event_event_filter' ) ):
    // Masonry Post Ajax Call Function.

    function outside_event_event_filter(){

        if(  isset( $_POST[ '_wpnonce' ] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ '_wpnonce' ] ) ), 'outside_event_ajax_nonce' ) ){
        	
        	echo $month = isset( $_POST['month'] ) ? $_POST['month'] : '';
        	echo $type = isset( $_POST['type'] ) ? $_POST['type'] : '';
        	echo $tags = isset( $_POST['tags'] ) ? $_POST['tags'] : '';

        	

            $data['month'] = $month;
            $data['type'] = $type;
            $data['tags'] = $tags;

            $data = http_build_query($data) . "\n";

            $event_content = wp_remote_get(  home_url().'/wp-json/outside-event/events?'.$data );
            $event_content = isset( $event_content['body'] ) ? $event_content['body'] : '';

            if( $event_content ){

	            $event_content = json_decode( $event_content );
	            $event_content = json_decode( $event_content );

	            echo '<pre>';
	            print_r( $event_content );
	            echo '</pre>';
	        }

        }

        wp_die();

    }

endif;