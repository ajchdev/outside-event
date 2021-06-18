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
        	
          	$month = isset( $_POST['month'] ) ? $_POST['month'] : '';
          	$type = isset( $_POST['type'] ) ? $_POST['type'] : '';
          	$tags = isset( $_POST['tags'] ) ? $_POST['tags'] : '';
            $limit = isset( $_POST['limit'] ) ? $_POST['limit'] : '';
            $data['month'] = $month;
            $data['type'] = $type;
            $data['tags'] = $tags;
            $data['limit'] = $limit;

            $data = http_build_query($data) . "\n";

            $event_content = wp_remote_get(  home_url().'/wp-json/outside-event/events?'.$data );
            $event_content = isset( $event_content['body'] ) ? $event_content['body'] : '';

            if( $event_content ){

	            $event_content = json_decode( $event_content );
	            $event_content = json_decode( $event_content );

	            foreach( $event_content as $event){

                outside_event_frontend_render_events($event);

              }
	        }

        }

        wp_die();

    }

endif;

add_action('wp_ajax_outside_event_event_pagination', 'outside_event_event_pagination');
add_action('wp_ajax_nopriv_outside_event_event_pagination', 'outside_event_event_pagination');

if( !function_exists( 'outside_event_event_pagination' ) ):
    // Masonry Post Ajax Call Function.

    function outside_event_event_pagination(){

        if(  isset( $_POST[ '_wpnonce' ] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ '_wpnonce' ] ) ), 'outside_event_ajax_nonce' ) ){
            
            $month = isset( $_POST['month'] ) ? $_POST['month'] : '';
            $type = isset( $_POST['type'] ) ? $_POST['type'] : '';
            $paged = isset( $_POST['paged'] ) ? $_POST['paged'] : '';
            $limit = isset( $_POST['limit'] ) ? $_POST['limit'] : '';
            $data['month'] = $month;
            $data['type'] = $type;
            $data['tags'] = $tags;
            $data['c_page'] = $paged;
            $data['limit'] = $limit;

            $data = http_build_query($data) . "\n";
            $event_content = wp_remote_get(  home_url().'/wp-json/outside-event/events?'.$data );
            $event_content = isset( $event_content['body'] ) ? $event_content['body'] : '';

            if( $event_content ){

                $event_content = json_decode( $event_content );
                $event_content = json_decode( $event_content );

                foreach( $event_content as $event){ 
                  outside_event_frontend_render_events($event);
                }
            }

        }

        wp_die();

    }

endif;