<?php
if ( function_exists( 'acf_add_options_page' ) ) {

	/**
	 * Layout
	 */
	acf_add_options_page( array(
		'page_title' => 'Layout',
		'menu_title' => 'Layout',
		'menu_slug'  => 'content',
		'capability' => 'edit_pages',
		'redirect'   => true,
		'icon_url'   => 'dashicons-layout',
		'position'   => 60
	) );

	/**
	 * Information
	 */
	if ( current_user_can( 'edit_pages' ) ) {
		acf_add_options_sub_page( array(
			'menu_title'  => 'Information',
			'page_title'  => 'Information',
			'parent_slug' => 'options-general.php'
		) );
	}
}