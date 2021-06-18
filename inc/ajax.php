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

                $url = isset(  $event->url ) ? $event->url : '';
                $title = isset( $event->title ) ? $event->title : '';
                $excerpt = isset(  $event->excerpt ) ? $event->excerpt : '';
                $image = isset(  $event->image ) ? $event->image : ''; ?>

                <article>

                  <div class="event-content-wraper">

                    <?php

                    if(  $image ){
                      echo '<img src="' . esc_url( $image ) .'"/>';
                    }

                    echo '<h2><a href="' . esc_url( $url ) . '" rel="bookmark">'.esc_html( wp_trim_words( $title,20,'...' ) ).'</a></h2>';
                    ?>

                    <?php if($excerpt){ ?>
                      <div class="entry-content">
                        <?php echo wp_kses_post( $excerpt ); ?>
                      </div><!-- .entry-content -->
                    <?php } ?>

                  </div>

                </article><!-- #post-<?php the_ID(); ?> -->

                    <?php
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

                      $url = isset(  $event->url ) ? $event->url : '';
                      $title = isset( $event->title ) ? $event->title : '';
                      $excerpt = isset(  $event->excerpt ) ? $event->excerpt : '';
                      $image = isset(  $event->image ) ? $event->image : ''; ?>

                      <article>

                        <div class="event-content-wraper">

                          <?php

                          if(  $image ){
                            echo '<img src="' . esc_url( $image ) .'"/>';
                          }

                            echo '<h2><a href="' . esc_url( $url ) . '" rel="bookmark">'.esc_html( wp_trim_words( $title,20,'...' ) ).'</a></h2>';
                          ?>

                          <?php if($excerpt){ ?>
                            <div class="entry-content">
                            <?php echo wp_kses_post( $excerpt ); ?>
                            </div><!-- .entry-content -->
                          <?php } ?>
                          
                        </div>

                      </article><!-- #post-<?php the_ID(); ?> -->

                    <?php
                    }
            }

        }

        wp_die();

    }

endif;