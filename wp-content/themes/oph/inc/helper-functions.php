<?php

/** Snippets of code for custom authors */

// Objective here is to merge custom defined authors with WP default post authors
// Used on the filter-sidebar.php
function oph_merge_all_research_authors($official_research_authors, $custom_research_authors)
{
	$custom_research_authors_temp = []; // turning this into an object array

	if ( !empty($custom_research_authors) ) : foreach( $custom_research_authors as $obj) :
		// Filter any wordpress users
		if ( get_user_by('login', $obj->custom_author) ) continue;

		$custom_research_authors_temp[] = (object)[
			'ID'            => '',
			'user_login'	=> $obj->custom_author,
			'user_nicename' => $obj->custom_author,
			'user_email'    => '',
			'display_name'  => $obj->custom_author
		];
	endforeach; endif;

	$results = array_merge($official_research_authors, $custom_research_authors_temp);

	return $results;
}

// Consolidated author query here to handle both wp core users and custom authors
function oph_get_post_author_name($post_id='')
{
	if ( !$post_id ) {
		$post_id = get_the_ID();
	}
	
	// Check for custom author
	$author = get_post_meta($post_id,'custom_author', true);

	// Fetch from wp users
	if ( !$author ) {
		$post = get_post($post_id);
		$author = get_the_author_meta( 'display_name', $post->post_author );
	}

	return $author;	
}

/**
 *
 * @param array $author_list
 * @return array of author_ids
 */
function oph_has_only_core_authors($author_list)
{
	$author_ids = [];

	foreach($author_list as $author_login) {
		if ( $user = get_user_by('login', $author_login) ) {
			$author_ids[] = $user->ID;
			continue;
		}

		return false;
	}

	return $author_ids;
}

function oph_has_only_custom_authors($author_list)
{
	foreach($author_list as $author_login) {
		if ( get_user_by('login', $author_login) ) return false;
	}

	return true;
}

function oph_extract_core_authors($author_list)
{
	$author_ids = [];

	foreach($author_list as $author_login) {
		if ( $user = get_user_by('login', $author_login) ) {
			$author_ids[] = $user->ID;
		}
	}

	return $author_ids;
}

function oph_extract_custom_authors($author_list)
{
	$author_names = [];

	foreach($author_list as $author_login) {
		if ( !get_user_by('login', $author_login) ) {
			$author_names[] = $author_login;
		}
	}

	return $author_names;
}

// Adding 'Display Author' to Research Post List Columns 
add_filter( 'manage_research_posts_columns', 'add_displayAuthor_column');
/**
 * Add new columns to the post table
 *
 * @param Array $columns - Current columns on the list post
 */

// Create New Column
function add_displayAuthor_column( $columns ) { 
  $columns['custom_author'] = __( 'Display Author' ); 
  return $columns; 
} 
// Populate New Column
add_action( 'manage_research_posts_custom_column', 'researchAuthor_column', 10, 2);
function researchAuthor_column( $column, $post_id ) {
  if ( 'custom_author' === $column ) {
    $author = get_post_meta( $post_id, 'custom_author', true );

    if ( ! $author ) {
      _e( 'None' );  
    } else {
      echo $author;
    }
  } 
}