<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package Outside Event Custom API Endpoint
 * @version 1.0.0
 */

if ( ! class_exists( 'Outside_Event_Custom_API' ) ) {

    class Outside_Event_Custom_API{

    	function __construct(){
    		
            add_action( 'rest_api_init',array( $this,'outside_event_api_route' ) );

	    }


        function outside_event_api_route() {

            // Set route for event api
            register_rest_route( 'outside-event', 'events', array(
                    'methods' => 'GET',
                    'callback' => array( $this,'outside_event_get_event_callback' ),
                    'permission_callback' => '',
                )
            );
        }

        function outside_event_get_event_callback() {
            /**
             * Return json data callback
            **/

            // Get data form url
            $limit = isset( $_GET['limit'] ) ? $_GET['limit'] : '10';
            $type = isset( $_GET['type'] ) ? $_GET['type'] : '';
            $c_page = isset( $_GET['c_page'] ) ? $_GET['c_page'] : '';

            // arga for event post query
            $args_new  =  array(
              'post_type' => 'outside-event',
              'posts_per_page' => $limit,
              'paged'           => $c_page,
            );

            if( $type ){

                $args_new['tax_query'] = array(
                    array(
                        'taxonomy' => 'event-type',
                        'field'    => 'term_id',
                        'terms'    => $type,
                    ),
                );
            }

            // Query for event posts
            $loop_new = new WP_Query($args_new);

            $post_data = array();
            if( $loop_new->have_posts() ):
                
                while( $loop_new->have_posts() ) : $loop_new->the_post();

                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
                    $featured_image = isset( $featured_image[0] ) ? $featured_image[0] : '';
                    $event_location = get_post_meta( get_the_ID(), 'outside_event_location', true );
                    $event_date = get_post_meta( get_the_ID(), 'outside_event_date', true );
                    $event_time = get_post_meta( get_the_ID(), 'outside_event_time', true );

                    $post_data[] = array(
                        'url' => get_the_permalink(),
                        'title' => get_the_title(),
                        'content' => get_the_content(),
                        'image' => $featured_image,
                        'tags' => '',
                        'terms' => '',
                        'location' => $event_location,
                        'date' =>  $event_date,
                        'posted_date' =>  get_the_date( get_option('date_formate') ),
                        'time' =>  $event_time,
                        'post_id' => get_the_ID(),
                    );

                endwhile;

                wp_reset_query();
            
            endif;

            if( $post_data ){

                $post_data = json_encode( $post_data);

                // Return Event posts
                return rest_ensure_response( $post_data );

            }

            return rest_ensure_response( esc_html__('No Event Found'),'outside-event' );

        }

    }

    new Outside_Event_Custom_API();

} ?>