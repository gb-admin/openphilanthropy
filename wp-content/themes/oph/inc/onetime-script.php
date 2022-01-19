<?php

/**
 * Programmatically populate the ACF's button field from organization link data in the grant post contents
 * TODO: Save to delete once applied
 */

add_action('init', 'oph_task_235_data_migration');

function oph_task_235_data_migration() {
	if ( get_transient('task_235_updated') ) return;

	$grants = get_posts(array(
		'post_type' => 'grants',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'title',
		'order' => 'ASC'
	));

	foreach($grants as $grant) {
		$grantee_site = get_field("org_website", $grant->ID);

		if ( !empty(get_field('page_header_button', $grant->ID)) ) continue;
		// Or we can choose to overwrite (not safe)
		// delete_post_meta($grant->ID, 'page_header_button');

		$row = [
			'link' => [
				'url'	 => $grantee_site,
				'title'	 => 'Visit Grantee Site',
				'target' => '_blank'
			]
		];

		add_row('page_header_button', $row, $grant->ID);	
	}

	set_transient( 'task_235_updated', true, DAY_IN_SECONDS * 30 );
}