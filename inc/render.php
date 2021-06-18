<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package Outside Event
 * @version 1.0.0
 */

if( !function_exists('outside_event_frontend_render_events') ):

    function outside_event_frontend_render_events( $event ){

        // print_r( $event );
        $url = isset(  $event->url ) ? $event->url : '';
        $title = isset( $event->title ) ? $event->title : '';
        $excerpt = isset(  $event->excerpt ) ? $event->excerpt : '';
        $image = isset(  $event->image ) ? $event->image : '';
        $posted_date = isset(  $event->posted_date ) ? $event->posted_date : '';
        $month = isset(  $event->date ) ? $event->date : '';

        $event_day = isset(  $event->event_day ) ? $event->event_day : '';
        $event_year = isset(  $event->event_year ) ? $event->event_year : '';
        $location = isset(  $event->location ) ? $event->location : '';

       ?>
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

          <?php if($posted_date || $event_day || $event_year || $month ){ ?>
            <div class="meta-content">

              <?php if($posted_date){ ?>
                <div>

                  <h3><?php esc_html_e('Posted Date','outside-event'); ?></h3>
                  <?php echo wp_kses_post( $posted_date ); ?>

                </div>
              <?php } ?>

              <?php if($event_day || $month || $event_year ){ ?>
                <div>

                  <h3><?php esc_html_e('Event Happening Date','outside-event'); ?></h3>

                  <?php
                  echo wp_kses_post( $event_day );
                  if( $month ){
                    echo ','.wp_kses_post( $month );
                  }
                  if( $event_year ){
                    echo ','.wp_kses_post( $event_year );
                  }
                  ?>
                </div>
              <?php } ?>

            </div><!-- .entry-content -->
          <?php } ?>
          
        </div>

      </article><!-- #post-<?php the_ID(); ?> -->


    <?php
    }

endif;