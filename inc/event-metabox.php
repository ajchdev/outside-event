<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Create a metabox to added some custom filed in event posts.
 *
 * @package Outside Event
 */

 add_action( 'add_meta_boxes', 'outside_event_post_meta_options' );
 
 if( ! function_exists( 'outside_event_post_meta_options' ) ):
 function  outside_event_post_meta_options() {
    add_meta_box(
                'outside_event_post_meta',
                esc_html__( 'Event Fields', 'outside-event' ),
                'outside_event_post_meta_callback',
                'outside-event', 
                'normal', 
                'high'
            );
 }
 endif;

/**
 * Callback function for post option
 */
if( ! function_exists( 'outside_event_post_meta_callback' ) ):

    function outside_event_post_meta_callback() {

        global $post;

        wp_nonce_field( basename( __FILE__ ), 'outside_event_event_meta_nonce' );
        $outside_event_location = get_post_meta( $post->ID, 'outside_event_location', true );
        $outside_event_date = get_post_meta( $post->ID, 'outside_event_date', true );
        $outside_event_time = get_post_meta( $post->ID, 'outside_event_time', true );
        ?>

        <table class="form-table">

            <tr>
                <td>
                    <label><?php esc_html_e('Event Location','outside-event'); ?></label>
                    <input type="text" name="outside_event_location" value="<?php echo esc_attr( $outside_event_location ); ?>" />
                    
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php esc_html_e('Event Date','outside-event'); ?></label>
                    <input class="oe-date-pick" type="text" name="outside_event_date" value="<?php echo esc_attr( $outside_event_date ); ?>" />
                    
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php esc_html_e('Event Time','outside-event'); ?></label>
                    <input type="text" name="outside_event_time" value="<?php echo esc_attr( $outside_event_time ); ?>" />
                    
                </td>
            </tr>

        </table>
        <?php       
    }
endif;

/*--------------------------------------------------------------------------------------------------------------*/
/**
 * Function for save value of meta opitons
 *
 * @since 1.0.0
 */
add_action( 'save_post', 'outside_event_save_post_meta' );

if( ! function_exists( 'outside_event_save_post_meta' ) ):

function outside_event_save_post_meta( $post_id ) {

    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'outside_event_event_meta_nonce' ] ) || !wp_verify_nonce( wp_unslash($_POST['outside_event_event_meta_nonce'] ), basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
        
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can( 'edit_page', $post_id ) )
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;  
    }

    $outside_event_location_old = esc_html( get_post_meta( $post_id, 'outside_event_location', true ) ); 
    $outside_event_location_new = sanitize_text_field( wp_unslash( $_POST['outside_event_location'] ));

    if ( $outside_event_location_new && $outside_event_location_new != $outside_event_location_old ) {

        update_post_meta ( $post_id, 'outside_event_location', $outside_event_location_new );

    } elseif ( '' == $outside_event_location_new && $outside_event_location_old ) {

        delete_post_meta( $post_id,'outside_event_location', $outside_event_location_old );

    }

    $outside_event_date_old = esc_html( get_post_meta( $post_id, 'outside_event_date', true ) ); 
    $outside_event_date_new = sanitize_text_field( wp_unslash( $_POST['outside_event_date'] ));

    if ( $outside_event_date_new && $outside_event_date_new != $outside_event_date_old ) {

        update_post_meta ( $post_id, 'outside_event_date', $outside_event_date_new );

    } elseif ( '' == $outside_event_date_new && $outside_event_date_old ) {

        delete_post_meta( $post_id,'outside_event_date', $outside_event_date_old );

    }

    $outside_event_time_old = esc_html( get_post_meta( $post_id, 'outside_event_time', true ) ); 
    $outside_event_time_new = sanitize_text_field( wp_unslash( $_POST['outside_event_time'] ));

    if ( $outside_event_time_new && $outside_event_time_new != $outside_event_time_old ) {

        update_post_meta ( $post_id, 'outside_event_time', $outside_event_time_new );

    } elseif ( '' == $outside_event_time_new && $outside_event_time_old ) {

        delete_post_meta( $post_id,'outside_event_time', $outside_event_time_old );

    }


}
endif;  