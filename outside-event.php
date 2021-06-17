<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package Outside Event
 * @version 1.0.0
 */

/*
* Plugin Name: Outside Event
* Version: 1.0.0
* Plugin URI:
* Description: This plugin manage to show event lists with filter functionality.
* Author: Ajay Chaudhary
* Author URI:
* Requires at least: 4.5
* Tested up to: 5.7
* Text Domain: outside-event
*/

define( 'OUTSIDE_EVENT_PATH', plugin_dir_path( __FILE__ ) );
define( 'OUTSIDE_EVENT_URL', plugin_dir_url( __FILE__ ) );
define( 'OUTSIDE_EVENT_LANG_DIR', basename( dirname( __FILE__ ) ) . '/languages/' );


if ( ! class_exists( 'Outside_Event_Class' ) ) :

    class Outside_Event_Class{

    	function __construct(){
    		
            // Add a filter to 'template_include' hook
            add_filter( 'template_include',array( $this,'outside_event_template' ) );
            add_action( 'admin_enqueue_scripts',array( $this,'outside_event_backend_scripts' ) );
            
    		include_once OUTSIDE_EVENT_PATH . 'inc/event-post-type.php';
            include_once OUTSIDE_EVENT_PATH . 'inc/event-metabox.php';
            include_once OUTSIDE_EVENT_PATH . 'inc/event-custom-api.php';
            include_once OUTSIDE_EVENT_PATH . 'inc/event-shortcode.php';

	    }


        function outside_event_template( $template ) {

            // If the current url is an archive of any kind
            if( is_singular('outside-event') || is_post_type_archive('outside-event') || is_tax('event-type') ) {
                // Set this to the template file inside your plugin folder
                $template = WP_PLUGIN_DIR .'/'. plugin_basename( dirname(__FILE__) ) .'/templates/single-outside-event.php';
            }

            // Always return, even if we didn't change anything
            return $template;

        }

	    public function outside_event_backend_scripts(){

            // Load the datepicker style (pre-registered in WordPress).
            wp_enqueue_style( 'jquery-ui' ); 
            
            // Load the datepicker script (pre-registered in WordPress).
            wp_enqueue_script( 'jquery-ui-datepicker' );

            wp_enqueue_script( 'outside-event-admin', OUTSIDE_EVENT_URL . 'assets/js/admin.js', array('jquery'), true );

        }

    }

    $GLOBALS[ 'outside_event_global' ] = new Outside_Event_Class();

endif; ?>