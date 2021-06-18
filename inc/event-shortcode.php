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

              echo '<div class="outside-events-lists">';
               if( isset( $inputs['filter'] ) && $inputs['filter'] = 'show' ){
                
                $this->outside_event_render_event_filter($inputs); 
               }

               $this->outside_event_render_event_lists($inputs); 

               if( isset( $inputs['pagination'] ) && $inputs['pagination'] = 'pagination' ){
                
                $this->outside_event_render_event_pagination($inputs); 
               }
               echo '</div>';

            $html = ob_get_contents();
            ob_get_clean();

            return $html;

        }

        public function outside_event_render_event_filter($inputs){

          $event_types = $this->outside_event_get_event_type();
          $event_tags = $this->outside_event_get_event_tags();
          ?>

          <div class="event-filter">
            <h2><?php esc_html_e('Event Type Filter','outside-event'); ?></h2>
            
            <form class="event-filter-form">

              <?php if( isset( $inputs['limit'] ) && $inputs['limit'] ){ ?>
                <input type="hidden" class="filter-event-limit" value="<?php echo esc_attr( $inputs['limit'] ); ?>">
              <?php } ?>

              <?php if( $event_types ){ ?>

                <div class="filter-fields">

                  <label><?php esc_html_e('Filter by Event Type','outside-event'); ?></label>

                  <select class="filter-event-type">

                    <option value=""><?php esc_html_e('Select Event Type','outside-event'); ?></option>

                    <?php foreach( $event_types as $event_type ){

                      $name = isset( $event_type->name ) ? $event_type->name : '';
                      $slug = isset( $event_type->slug ) ? $event_type->slug : ''; ?>

                      <option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></option>

                    <?php } ?>

                  </select>
                </div>

              <?php } ?>

              <?php if( $event_types ){ ?>

                <div class="filter-fields">
                  <label><?php esc_html_e('Filter by Event Tags','outside-event'); ?></label>
                  <select class="filter-event-tags">

                    <option value=""><?php esc_html_e('Select Event Tags','outside-event'); ?></option>

                    <?php foreach( $event_tags as $event_tag ){

                        $name = isset( $event_tag->name ) ? $event_tag->name : '';
                        $slug = isset( $event_tag->slug ) ? $event_tag->slug : ''; ?>

                        <option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></option>

                      <?php } ?>

                  </select>
                </div>

                <?php } ?>

                <div class="filter-fields">
                  <label><?php esc_html_e('Filter by Month','outside-event'); ?></label>
                  <select class="filter-event-month">

                    <option value=""><?php esc_html_e('Select Date','outside-event'); ?></option>

                    <?php
                    $months = array(
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July ',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    );
                    foreach( $months as $key => $month ){ ?>

                     <option value="<?php echo esc_attr( $month ); ?>"><?php echo esc_html( $month ); ?></option>

                    <?php } ?>

                  </select>
                </div>

              <input class="filter-events-submit" type="submit">

            </form>

          </div>
          <?php

        }

        public function outside_event_render_event_lists( $inputs ){
          
            $type = isset( $inputs['type'] ) ? $inputs['type'] : '';
            $limit = isset( $inputs['limit'] ) ? $inputs['limit'] : '';
            $c_page = isset( $inputs['c_page'] ) ? $inputs['c_page'] : '';
            $data = array();
            if( $type ){
            $data['type'] = $type;
            }

            if( $limit ){
            $data['limit'] = $limit;
            }

            if( $c_page ){
              $data['c_page'] = $c_page;
            }
          
            // $data['fields'] = array('content1','image1','tags1','terms1');
            // $data['month'] = 'August';
            $data = http_build_query($data) . "\n";

            // echo home_url().'/wp-json/outside-event/events?'.$data;
            $event_content = wp_remote_get(  home_url().'/wp-json/outside-event/events?'.$data );
            $event_content = isset( $event_content['body'] ) ? $event_content['body'] : '';
            
            if( $event_content ){

            $event_content = json_decode( $event_content );
            $event_content = json_decode( $event_content );
            // print_r(  $event_content );
            if( $event_content ){
            echo '<div class="events-lists-wrap">';

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
            echo '</div>';
          }
            }

        }

        public function outside_event_get_event_type(){

          return $terms = get_terms( array(
            'taxonomy' => 'event-type',
            'hide_empty' => false,
          ) );

        }

        public function outside_event_get_event_tags(){

          return $terms = get_terms( array(
            'taxonomy' => 'event-tag',
            'hide_empty' => false,
          ) );

        }

        public function outside_event_render_event_pagination($inputs){
        $limit = isset( $inputs['limit'] ) ? $inputs['limit'] : ''; ?> 
            
            <div class="otuside-pagination-wpap">
              <a href="javascript:void(0)" class="otuside-pagination" paged-data="2" data-limit="<?php echo esc_attr( $limit ); ?>"><?php esc_html_e('Load MoreEvents','outside-event'); ?></a></div>

        <?php
        }

    }

    new Outside_Event_shortcode();
}

