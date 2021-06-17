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
        public function outside_event_shortcode($inputs){

            ob_start();
            $html = '';

               $type = isset( $inputs['type'] ) ? $inputs['type'] : '';
               $limit = isset( $inputs['limit'] ) ? $inputs['limit'] : '';
               $pagination = isset( $inputs['pagination'] ) ? $inputs['pagination'] : '';
               
               if( isset( $inputs['filter'] ) ){
                $this->outside_event_render_event_filter(); 
               }

               $data = array();
               if( $type ){
                  $data['type'] = $type;
               }

               if( $limit ){
                  $data['limit'] = $limit;
               }

               $data['c_page'] = 1;
               $data['fields'] = array('content1','image1','tags1','terms1');
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

            $html = ob_get_contents();
            ob_get_clean();

            return $html;

        }

        public function outside_event_render_event_filter(){

          

        }


    }

    new Outside_Event_shortcode();
}

