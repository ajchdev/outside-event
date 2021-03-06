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
            $default_posts_per_page = get_option( 'posts_per_page' );
            $limit = isset( $_GET['limit'] ) ? $_GET['limit'] : '';
            if( empty( $limit ) ){ $limit = $default_posts_per_page; }
            $type = isset( $_GET['type'] ) ? $_GET['type'] : '';
            $tags = isset( $_GET['tags'] ) ? $_GET['tags'] : '';
            $c_page = isset( $_GET['c_page'] ) ? $_GET['c_page'] : '';
            $fields = isset( $_GET['fields'] ) ? $_GET['fields'] : '';
            $month = isset( $_GET['month'] ) ? $_GET['month'] : '';

            // arga for event post query
            $args_new  =  array(
              'post_type' => 'outside-event',
              'posts_per_page' => $limit,
              'paged'           => $c_page,
            );


            $args_new['tax_query'] = array(
                'relation' => 'AND',
            );

            if( $type ){

                $args_new['tax_query'][] = array(
                        'taxonomy' => 'event-type',
                        'field'    => 'slug',
                        'terms'    => $type,
                    );
            }

            if( $tags ){

                $args_new['tax_query'][] = array(
                        'taxonomy' => 'event-tag',
                        'field'    => 'slug',
                        'terms'    => $tags,
                    );
            }

            if( $month ){
                $args_new['meta_query'] = array(
                    array(
                        'key'       => 'outside_event_month',
                        'value'     => $month,
                    )
                );
            }

            $ed_content = false;
            $ed_terms = false;
            $ed_tags = false;
            if( $fields && is_array( $fields ) ){

                if( in_array(  'content', $fields ) ){ $ed_content = true; }
                if( in_array(  'terms', $fields ) ){ $ed_terms = true; }
                if( in_array(  'tags', $fields ) ){ $ed_tags = true; }

            }
            
            // Query for event posts
            $loop_new = new WP_Query($args_new);

            $post_data = array();
            if( $loop_new->have_posts() ):
                
                while( $loop_new->have_posts() ) : $loop_new->the_post();

                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
                    $featured_image = isset( $featured_image[0] ) ? $featured_image[0] : '';
                    $event_location = get_post_meta( get_the_ID(), 'outside_event_location', true );
                    $event_date = get_post_meta( get_the_ID(), 'outside_event_month', true );
                    $event_time = get_post_meta( get_the_ID(), 'outside_event_time', true );
                    $term_list = wp_get_post_terms(get_the_ID(), 'event-type', array("fields" => "all"));
                    $taga_list = wp_get_post_terms(get_the_ID(), 'event-tag', array("fields" => "all"));
                    $event_day = get_post_meta( get_the_ID(), 'outside_event_day', true );
                    $event_year = get_post_meta( get_the_ID(), 'outside_event_year', true );
                    $excerpt = '';
                    if( has_excerpt() ){
                        $excerpt = get_the_excerpt();
                    }else{
                        $excerpt = '<p>'.esc_html( wp_trim_words( get_the_content(),25,'...' ) ).'</p>';
                    }

                    $post_data[] = array(
                        'url' => get_the_permalink(),
                        'title' => get_the_title(),
                        'excerpt' => $excerpt,
                        'content' => $ed_content ? get_the_content() : '',
                        'terms' => $ed_terms ? $term_list : '',
                        'tags' => $ed_tags ? $taga_list : '',
                        'image' => $featured_image,
                        'location' => $event_location,
                        'date' =>  $event_date,
                        'posted_date' =>  get_the_date( get_option('date_formate') ),
                        'time' =>  $event_time,
                        'event_day' =>  $event_day,
                        'event_year' =>  $event_year,
                        'post_id' => get_the_ID(),
                        // 'args_new' =>  $args_new,
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