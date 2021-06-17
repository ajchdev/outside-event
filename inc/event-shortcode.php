<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package Outside Event Shortcode
 * @version 1.0.0
 */


if ( ! class_exists( 'Outside_Event_shortcode' ) ) {

    class Outside_Event_shortcode{

    	function __construct(){
    		    
        // Register shortcode
        add_shortcode('event', array($this, 'outside_event_shortcode'));
	    }

        // Author Box Shortcode.
        function outside_event_shortcode($inputs){

            ob_start();
            $html = '';

               $term = isset( $inputs['type'] ) ? $inputs['type'] : '';
               $limit = isset( $inputs['limit'] ) ? $inputs['limit'] : '10';
               $pagination = isset( $inputs['pagination'] ) ? $inputs['pagination'] : '10';
               $filter = isset( $inputs['filter'] ) ? $inputs['filter'] : '10';
               $limit = isset( $inputs['limit'] ) ? $inputs['limit'] : '10';

               $event_content = wp_remote_get( esc_url( home_url().'/wp-json/outside-event/events?post_per_page=1' ) );
               $event_content = isset( $event_content['body'] ) ? $event_content['body'] : '';

               if( $event_content ){
                
                  $event_content = json_decode( $event_content );
                  $event_content = json_decode( $event_content );
                  echo '<pre>';
                  print_r( $event_content );
                  echo '</pre>';

               }

            $html = ob_get_contents();
            ob_get_clean();

            return $html;

        }


    }

    new Outside_Event_shortcode();
}

