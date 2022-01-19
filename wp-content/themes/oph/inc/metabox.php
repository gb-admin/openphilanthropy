<?php

/**
 * Adding a custom author metabox to the following post types: Research
 * 
 */
add_action('add_meta_boxes', 'oph_create_custom_author_metabox');
add_action('save_post', 'oph_save_custom_author_metabox');

function oph_create_custom_author_metabox()
{
	global $screens;

	$screens = ['research'];

	add_meta_box(
		'custom_author_metabox',  	   // Unique ID
		__('Custom Author', 'oph'),    // Box title
		'oph_custom_author_template',  // Content callback, must be of type callable
		$screens,
		'side',
		'core'
	);
}

function oph_custom_author_template($post)
{
	$current_author = get_post_meta($post->ID, 'custom_author', true) ?: get_the_author_meta( 'display_name', $post->post_author );
	$wp_core_users = array_map(function($e) { return $e->display_name;},  get_users());
	$post_meta_authors = array_map(function($e) { return $e->custom_author;},  oph_get_all_custom_authors());

	$filtered_users = array_unique(array_merge($wp_core_users, $post_meta_authors));
	?>
	<style>
		#custom_author {
			padding: 3px 8px;
			width: 100%;
			margin-top: 5px;
		}
	</style>
	<label for="custom_author"><?php _e("Select or type one below", "oph"); ?></label> <br/>
	<input list="custom_authors" id="custom_author" name="custom_author" value="<?= esc_html($current_author); ?>" />
	<datalist id="custom_authors">
		<?php 
		foreach( $filtered_users as $display_name ) : ?>
		<option value="<?= esc_html($display_name); ?>">
		<?php endforeach; ?>
	</datalist>
	<?php
}

function oph_get_all_custom_authors()
{
	global $wpdb;

	$authors = $wpdb->get_results(
		"SELECT DISTINCT(meta_value) AS custom_author
		FROM $wpdb->postmeta WHERE meta_key = 'custom_author'");

	return $authors;
}

function oph_save_custom_author_metabox($post_id) {
	if ( array_key_exists('custom_author', $_POST ) ) {
		$custom_author = sanitize_user($_POST['custom_author']);
		update_post_meta($post_id, 'custom_author', $custom_author);
	}
}

/** End of custom author metabox **/