<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
* Custom post Type, Taxonomy
*/
 
function outside_event_custom_post_type() {
 
    // Custom Post Type Labels
    $labels = array(
        'name'                => _x( 'Events', 'outside-event' ),
        'singular_name'       => _x( 'Event', 'outside-event' ),
        'menu_name'           => esc_html__( 'Events', 'outside-event' ),
        'parent_item_colon'   => esc_html__( 'Parent Event', 'outside-event' ),
        'all_items'           => esc_html__( 'All Events', 'outside-event' ),
        'view_item'           => esc_html__( 'View Event', 'outside-event' ),
        'add_new_item'        => esc_html__( 'Add New Event', 'outside-event' ),
        'add_new'             => esc_html__( 'Add New', 'outside-event' ),
        'edit_item'           => esc_html__( 'Edit Event', 'outside-event' ),
        'update_item'         => esc_html__( 'Update Event', 'outside-event' ),
        'search_items'        => esc_html__( 'Search Event', 'outside-event' ),
        'not_found'           => esc_html__( 'Not Found', 'outside-event' ),
        'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'outside-event' ),
    );
    
    // Custom Post Type setting
    $args = array(
        'label'               => esc_html__( 'Event', 'outside-event' ),
        'description'         => esc_html__( 'Event Lists', 'outside-event' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'outside-event', $args );
 
}
 
add_action( 'init', 'outside_event_custom_post_type', 0 );

//create a custom taxonomy
add_action( 'init', 'outside_event_taxonomy', 0 );
 
function outside_event_taxonomy() {
 
    // Taxonomy labels

    $labels = array(
        'name' => esc_html__( 'Events Type', 'outside-event' ),
        'singular_name' => esc_html__( 'Event Type', 'outside-event' ),
        'search_items' =>  esc_html__( 'Search Events Type', 'outside-event' ),
        'all_items' => esc_html__( 'All Events Type', 'outside-event' ),
        'parent_item' => esc_html__( 'Parent Event Type', 'outside-event' ),
        'parent_item_colon' => esc_html__( 'Parent Event Type:', 'outside-event' ),
        'edit_item' => esc_html__( 'Edit Event Type', 'outside-event' ),
        'update_item' => esc_html__( 'Update Event Type', 'outside-event' ),
        'add_new_item' => esc_html__( 'Add New Event Type', 'outside-event' ),
        'new_item_name' => esc_html__( 'New Event Type Name', 'outside-event' ),
        'menu_name' => esc_html__( 'Events Type', 'outside-event' ),
    );    

    // taxonomy register
    register_taxonomy('event-type',array('outside-event'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event-type' ),
    ));
 
}

//create a custom taxonomy
add_action( 'init', 'outside_tags_taxonomy', 0 );

function outside_tags_taxonomy() {
 
    // Taxonomy labels

    $labels = array(
        'name' => _x( 'Tags', 'outside-event' ),
        'singular_name' => _x( 'Tag', 'outside-event' ),
        'search_items' =>  esc_html__( 'Search Tags', 'outside-event' ),
        'all_items' => esc_html__( 'All Tags', 'outside-event' ),
        'parent_item' => esc_html__( 'Parent Tag', 'outside-event' ),
        'parent_item_colon' => esc_html__( 'Parent Tag:', 'outside-event' ),
        'edit_item' => esc_html__( 'Edit Tag', 'outside-event' ),
        'update_item' => esc_html__( 'Update Tag', 'outside-event' ),
        'add_new_item' => esc_html__( 'Add New Tag', 'outside-event' ),
        'new_item_name' => esc_html__( 'New Tag Name', 'outside-event' ),
        'menu_name' => esc_html__( 'Tags', 'outside-event' ),
    );    

    // taxonomy register
    register_taxonomy('event-tag',array('outside-event'), array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event-tag' ),
    ));
 
}