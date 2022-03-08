<?php

/**
 * Adding a custom author metabox to the following post types: Research
 * 
 */
add_action('add_meta_boxes', 'oph_create_custom_author_metabox');
add_action('save_post', 'oph_save_custom_author_metabox', 10, 2);

function oph_create_custom_author_metabox()
{
	global $screens;

	$screens = ['research'];

	add_meta_box(
		'custom_author_metabox',  	   // Unique ID
		__('Display Author', 'oph'),    // Box title
		'oph_custom_author_template',  // Content callback, must be of type callable
		$screens,
		'side',
		'core'
	);
}

// creates custom meta box output
function oph_custom_author_template() {
    global $post;  // set $post to the current post ID
    $originalpost = $post;  // stores the current $post so it can be reset after a wp_query()
    wp_nonce_field( basename( __FILE__ ), 'research__meta_nonce' );  // sets nonce to be checked when saving meta
    $displayAuthor = get_post_meta( $post->ID, 'custom_author', true );  // gets the meta data if it already exists
    
    // outputs a simple text field
    echo '<p>Enter the Author for this post.</p>'; 
    echo '<input type="custom_author" name="custom_author" id="custom_author" value="' . esc_textarea( $displayAuthor )  . '" class="widefat">';
}

// saves custom meta box data
function oph_save_custom_author_metabox( $post_id, $post ) {
  // return if the user doesn't have edit permissions.
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
    return $post_id;
  }
  // return unless nonce is verified
  if ( ! isset( $_POST['research__meta_nonce'] ) || ! wp_verify_nonce( $_POST['research__meta_nonce'], basename(__FILE__) ) ) {
    return $post_id;
  }
  // sanitize the meta data save it into an array
  $meta_array['custom_author'] = esc_textarea( $_POST['custom_author'] );
  // $meta_array['_meta_field2'] = esc_textarea( $_POST['_meta_field2'] );

  foreach ( $meta_array as $key => $value ) :
    // avoid duplicate data during revisions
    if ( 'revision' === $post->post_type ) {
        return;
    }
    // update the meta value it if already has one
    if ( get_post_meta( $post_id, $key, false ) ) {
        update_post_meta( $post_id, $key, $value );
    // otherwise create meta entry with new value
    } else {
        add_post_meta( $post_id, $key, $value);
    }
    // delete meta entry if the field has no value
    if ( ! $value ) {
        delete_post_meta( $post_id, $key );
    }
  endforeach;
}

// function oph_get_all_custom_authors()
// {
// 	global $wpdb;

// 	$authors = $wpdb->get_results(
// 		"SELECT DISTINCT(meta_value) AS custom_author
// 		FROM $wpdb->postmeta WHERE meta_key = 'custom_author'");

// 	return $authors;
// }

/** End of custom author metabox **/ 


/**
 * Remove Custom Fields meta box
 */
add_action( 'admin_menu' , 'oph_remove_post_metabox' );
function oph_remove_post_metabox() {
    remove_meta_box( 'commentstatusdiv' , 'research' , 'normal' );
    remove_meta_box( 'commentsdiv' , 'research' , 'normal' ); 
}