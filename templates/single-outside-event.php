<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Outside Event
 */

get_header(); ?>

<div class="event-container clearfix">

	<?php
	while ( have_posts() ) :
		the_post();

		
	    $term_list = wp_get_post_terms(get_the_ID(), 'event-type', array("fields" => "all"));
	    $taga_list = wp_get_post_terms(get_the_ID(), 'event-tag', array("fields" => "all"));

	    $excerpt = '';
	    if( has_excerpt() ){
	        $excerpt = get_the_excerpt();
	    }else{
	        $excerpt = '<p>'.esc_html( wp_trim_words( get_the_content(),25,'...' ) ).'</p>';
	    }

      $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
	    $image = isset( $image[0] ) ? $image[0] : '';
      $posted_date = get_the_date( get_option('date_formate') );
      $month = get_post_meta( get_the_ID(), 'outside_event_month', true );
      $event_day = get_post_meta( get_the_ID(), 'outside_event_day', true );
      $event_year = get_post_meta( get_the_ID(), 'outside_event_year', true );
      $location = get_post_meta( get_the_ID(), 'outside_event_location', true );

       ?>
       <article>

        <div class="event-content-wraper">

          <?php

          if(  $image ){
            echo '<img src="' . esc_url( $image ) .'"/>';
          }
              
    			if ( is_singular() ) :
    				the_title( '<h1>', '</h1>' );
    			else :
    				echo '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">'.esc_html( wp_trim_words( get_the_title(),20,'...' ) ).'</a></h2>';
    			endif;

          if($excerpt){ ?>
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

          <?php
          if( $term_list ){
          	echo '<h3>'.esc_html__('Event Category','outside-event').'</h3>';
          	foreach( $term_list as $term ){
          		
          		$name = isset( $term->name ) ? $term->name : '';
          		$term_id = isset( $term->term_id ) ? $term->term_id : '';
          		$term_link = get_term_link($term_id,'event-type');
          		?>
          		<a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $name ); ?></a>
          		<?php
          	}

          } ?>

          <?php
          if( $taga_list ){
          	echo '<h3>'.esc_html__('Event Category','outside-event').'</h3>';
          	foreach( $taga_list as $tags ){
          		
          		$name = isset( $tags->name ) ? $tags->name : '';
          		$term_id = isset( $tags->term_id ) ? $tags->term_id : '';
          		$term_link = get_term_link($term_id,'event-tag');
          		?>
          		<a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $name ); ?></a>
          		<?php
          	}

          } ?>
          
        </div>

      </article><!-- #post-<?php the_ID(); ?> -->

	<?php
	endwhile; // End of the loop.
	?>

</div>
<?php
get_footer();