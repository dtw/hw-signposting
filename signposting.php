<?php

/*
Plugin Name: Healthwatch Signposting
Version: 1.5.5
Description: Implements a custom post type for signposting on Healthwatch websites. <strong>DO NOT DELETE !</strong>
Author: Phil Thiselton & Jason King
License: GPL2

Copyright 2020 Jason King (email : jason@kingjason.co.uk)

*/

defined( 'ABSPATH' ) or die( 'Sorry, nothing to see here.' );

/* 1. Create Signpost CUSTOM POST TYPE
-------------------------------------------------- */

add_action( 'init', 'hw_signpost_create_post_type' );
function hw_signpost_create_post_type() {
  register_post_type( 'signposts',
    array(

      'labels' => array(
        'name' => 'Signposts',
        'singular_name' => 'Signpost',
        'menu_name' => 'Signposts',
		'edit_item' => 'Edit Signpost',
		'view_item' => 'View Signposting',
		'search_items' => 'Search Signpost',
		'all_items' => 'All Signposts',
		'not_found' => 'No Signposts found',
		'add_new_item' => 'Add New Signpost'
	      ),
		'public' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'show_ui' => true,
		'menu_position' => 4,
		'show_in_nav_menus' => false,
		'menu_icon' => 'dashicons-flag',
		'rewrite' => array('slug' => 'signposts'),
		'supports' => array('title','editor'),
		'can_export' => 'true',
		'taxonomies' => array('signpost_categories','signpost_tags'),

    )
  );
}

/* 2. Register CUSTOM TAXONOMY
(Note that must add taxonomy to custom post type too)
		- signpost categories
------------------------------------------------------------------ */

function hw_signpost_categories_init() {

	register_taxonomy(
		'signpost_categories',
		'signposts',
		array(
			'label' => 'Signpost categories',
			'singular_name' => 'Signpost category',
			'rewrite' => array( 'slug' => 'signpost-category' ),
			'edit_item' => 'Edit Signpost category',
			'show_in_nav_menus' => true,
			'show_in_quick_edit' => true,
			'show_admin_column' => true,
			'hierarchical' => true,
      'capabilities' => array (
        'manage_terms' => 'activate_plugins',
        'edit_terms' => 'activate_plugins',
        'delete_terms' => 'activate_plugins',
        'assign_terms' => 'edit_posts',
      ),
		)
	);



}
add_action( 'init', 'hw_signpost_categories_init' );

/* 3. Add Admin COLUMNS
------------------------------------------------------------------ */

/**
This code modified from "Show modified Date in admin lists" plugin
http://apasionados.es
Version: 1.1
Apasionados.es
License: GPL2
*/

// Register Modified Date and Last Author Column for signposts post_type
function hw_signpost_modified_column_register( $columns ) {
  $columns['LastAuthor'] = __( 'Last Modified by', 'hw_signposting_show_modified_date_in_admin_lists' );
  $columns['Modified'] = __( 'Modified Date', 'hw_signposting_show_modified_date_in_admin_lists' );
	return $columns;
}
add_filter( 'manage_signposts_posts_columns', 'hw_signpost_modified_column_register' );

// Populate the two columns
function hw_signpost_modified_column_display( $column_name, $post_id ) {
  $modified_date_time = new DateTime(get_the_modified_date());
  switch ( $column_name ) {
  case 'Modified':
		global $post;
	       	echo '<p class="mod-date">';
          // if last modification was over a year ago colour it red
          if(date_format($modified_date_time->modify('+1 year'),'Y-m-d') < current_datetime('Y-m-d')) {
            echo '<span style="color:red;">';
            if (get_the_modified_date() == get_the_date()) {
              // if the post has never been modified
              echo 'Never</span><br>';
            } else {
              // otherwise show a human readable time since edit
              echo human_time_diff( strtotime(get_the_modified_date()), current_datetime()->getTimestamp() ) . ' ago</span><br>';
            }
          } else {
            // last mod not more than a year ago so show a human readable time since edit
            echo human_time_diff( strtotime(get_the_modified_date()), current_datetime()->getTimestamp() ) . ' ago<br>';
          }
          // show modified date (with timestamp on hover)
          echo '<span style="text-decoration: dotted underline;" title="'.get_the_modified_date().' '.get_the_modified_time().'">';
	       	echo get_the_modified_date($d='Y/m/d').'</span>';
			echo '</p>';
    break;
  // show last author
  case 'LastAuthor':
  	global $post;
         	echo '<p class="mod-author">';
          echo get_the_modified_author();
  		echo '</p>';
		break;
	}
}
add_action( 'manage_signposts_posts_custom_column', 'hw_signpost_modified_column_display', 10, 2 );

// Make the Modified column sortable
function hw_signpost_modified_column_register_sortable( $columns ) {
	$columns['Modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-signposts_sortable_columns', 'hw_signpost_modified_column_register_sortable' );

/* 4. Add the signposting shortcodes to a new signpost automatically
------------------------------------------------------------------ */

function hw_signpost_signposting_editor_content( $content, $post ) {

  $post_type = $post->post_type;
  if ( $post_type == 'signposts' ) {
    $content .= '
[signpost_phone][/signpost_phone]

[signpost_email][/signpost_email]

[signpost_website][/signpost_website]

[signpost_address][/signpost_address]

[signpost_location][/signpost_location]';
  }
  return $content;
}

add_filter( 'default_content', 'hw_signpost_signposting_editor_content', 10, 2 );

/* 5. Other signposts post type admin
------------------------------------------------------------------ */

function hw_signpost_remove_wp_seo_meta_box() {
	remove_meta_box('wpseo_meta', 'signposts', 'normal');
}
add_action('add_meta_boxes', 'hw_signpost_remove_wp_seo_meta_box', 100);

function addtoany_disable_sharing_on_my_custom_post_type() {
    if ( 'signposts' == get_post_type() ) {
        return true;
    }
}
add_filter( 'addtoany_sharing_disabled', 'addtoany_disable_sharing_on_my_custom_post_type' );

include("includes/shortcodes.php");

/**
 * Disable the "signposts" custom post type feed
 *
 * @since 1.0.0
 * @param object $query
 */
function hw_signpost_disable_signposts_feed( $query ) {
    if ( $query->is_feed() && in_array( 'signposts', (array) $query->get( 'post_type' ) ) ) {
        die( 'Signpost - feed disabled' );
    }
}
add_action( 'pre_get_posts', 'hw_signpost_disable_signposts_feed' );

// Add CUSTOM CSS to the SHORTCODES

function hw_signpost_shortcode_css() {
  wp_enqueue_style('signposting_shortcode_styles' , plugins_url().'/hw-signposting/css/style.css');
}

add_action('wp_enqueue_scripts', 'hw_signpost_shortcode_css');

?>
