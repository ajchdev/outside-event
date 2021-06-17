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

		?>
		<article <?php post_class(); ?>>

			<div class="event-content-wraper">

				<?php
				if ( is_singular() ) :
					the_title( '<h1>', '</h1>' );
				else :
					echo '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">'.esc_html( wp_trim_words( get_the_title(),20,'...' ) ).'</a></h2>';
				endif; ?>

				<div class="entry-content">
					<?php
					if( is_singular() ):

						echo '<div class="ta-content-wraper">';

							the_content( sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'outside-event' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							) );	

						echo '</div>';

					else:

						if( has_excerpt() ){
							the_excerpt();
						}else{
							echo '<p>'.esc_html( wp_trim_words( get_the_content(),20,'...' ) ).'</p>';
						}

					endif;
					
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'outside-event' ),
						'after'  => '</div>',
					) ); ?>

				</div><!-- .entry-content -->
				
			</div>

		</article><!-- #post-<?php the_ID(); ?> -->

	<?php
	endwhile; // End of the loop.
	?>

</div>
<?php
get_footer();