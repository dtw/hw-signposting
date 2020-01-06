<?php

/*

* Plugin Name: Healthwatch Signposting

* Description: Creates a custom post type for signposting

* Version: 1.0.0

* Author: Phil Thiselton & Jason King

* License: GPL2

/*  Copyright 2020 Jason King (email : jason@kingjason.co.uk)

*/



defined( 'ABSPATH' ) or die( 'Sorry, nothing to see here.' );





/* 1. Create Signpost CUSTOM POST TYPE
-------------------------------------------------- */

add_action( 'init', 'hw_signpost' );
function hw_signpost() {
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

function signposts_categories_init() {

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

		)
	);



}
add_action( 'init', 'signposts_categories_init' );

/* 3. Add Admin COLUMNS
------------------------------------------------------------------ */

/**
This code modified from "Show modified Date in admin lists" plugin
Plugin URI: http://apasionados.es
Description: Shows a new, sortable, column with the modified date in the lists of pages and posts in the WordPress admin panel. It also shows the username that did the last update.
Version: 1.1
Author: Apasionados.es
Author URI: http://apasionados.es
License: GPL2
*/

// Register Modified Date and Last Author Column for signposts post_type
function modified_column_register( $columns ) {
  $columns['LastAuthor'] = __( 'Last Modified by', 'hw_signposting_show_modified_date_in_admin_lists' );
  $columns['Modified'] = __( 'Modified Date', 'hw_signposting_show_modified_date_in_admin_lists' );
	return $columns;
}
add_filter( 'manage_signposts_posts_columns', 'modified_column_register' );

// Populate the two columns
function modified_column_display( $column_name, $post_id ) {
	switch ( $column_name ) {
	// show modified date (with timestamp on hover)
  case 'Modified':
		global $post;
	       	echo '<p class="mod-date">';
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
add_action( 'manage_signposts_posts_custom_column', 'modified_column_display', 10, 2 );

// Make the Modified column sortable
function modified_column_register_sortable( $columns ) {
	$columns['Modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-signposts_sortable_columns', 'modified_column_register_sortable' );

/* 4. Add the signposting shortcodes to a new signpost automatically
------------------------------------------------------------------ */

function signposting_editor_content( $content, $post ) {

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

add_filter( 'default_content', 'signposting_editor_content', 10, 2 );

/* 5. Other signposts post type admin
------------------------------------------------------------------ */

function my_remove_wp_seo_meta_box() {
	remove_meta_box('wpseo_meta', 'signposts', 'normal');
}
add_action('add_meta_boxes', 'my_remove_wp_seo_meta_box', 100);

function addtoany_disable_sharing_on_my_custom_post_type() {
    if ( 'signposts' == get_post_type() ) {
        return true;
    }
}
add_filter( 'addtoany_sharing_disabled', 'addtoany_disable_sharing_on_my_custom_post_type' );

include("includes/taxonomy-icons.php");
include("includes/shortcodes.php");

?>
