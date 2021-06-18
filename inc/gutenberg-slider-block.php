<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package Outside Event
 * @version 1.0.0
 */


if ( ! class_exists( 'Outside_Event_Register_Gutenberg_block' ) ) :

    class Outside_Event_Register_Gutenberg_block{

        function __construct(){

            add_action( 'enqueue_block_editor_assets',array( $this,'outside_event_gutenberg_script' ) );
            add_action( 'init',array( $this,'outside_event_register_slider_block' ) );

        }

        public function outside_event_gutenberg_script(){

            wp_enqueue_script(
                'outside-event-index',
                plugins_url( '../build/index.js', __FILE__ ),
                [
                    'wp-plugins',
                    'wp-blocks',
                    'wp-editor',
                    'wp-edit-post',
                    'wp-i18n',
                    'wp-element',
                    'wp-components',
                    'wp-data'
                ]
            );

        }

        public function outside_event_register_slider_block(){

            register_block_type(
                'outside-event-block/slider-block',
                [
                    'style' => 'outside-event-style',
                    'editor_style' => 'outside-event-editor',
                    'editor_scripts' => 'outside-event-editor',
                ]
            );

        }

    }

    new Outside_Event_Register_Gutenberg_block();

endif;