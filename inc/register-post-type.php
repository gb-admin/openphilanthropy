<?php
/**
 * Post Type: Blog
 */
function post_type_blog() {
	$labels = array(
		'name'                  => _x( 'Blog', 'Post type general name', 'oph' ),
		'singular_name'         => _x( 'Post', 'Post type singular name', 'oph' ),
		'menu_name'             => _x( 'Blog', 'Admin Post text', 'oph' ),
		'name_admin_bar'        => _x( 'Post', 'Add New on Toolbar', 'oph' ),
		'add_new'               => __( 'New Post', 'oph' ),
		'add_new_item'          => __( 'New Post', 'oph' ),
		'new_item'              => __( 'New Post', 'oph' ),
		'edit_item'             => __( 'Edit Post', 'oph' ),
		'view_item'             => __( 'View Post', 'oph' ),
		'all_items'             => __( 'All Posts', 'oph' ),
		'search_items'          => __( 'Search Posts', 'oph' ),
		'parent_item_colon'     => __( 'Parent Posts:', 'oph' ),
		'not_found'             => __( 'No posts found.', 'oph' ),
		'not_found_in_trash'    => __( 'No posts found in Trash.', 'oph' ),
		'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'oph' ),
		'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'archives'              => _x( 'Post archives', 'The post type archive label used in nav blog. Default “Post Archives”. Added in 4.4', 'oph' ),
		'insert_into_item'      => _x( 'Insert into blog', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'oph' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'oph' ),
		'filter_items_list'     => _x( 'Filter blog list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'oph' ),
		'items_list_navigation' => _x( 'Posts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'oph' ),
		'items_list'            => _x( 'Posts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'oph' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'blog' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-admin-post',
		'menu_position'      => null,
		'supports'           => array( 'author', 'editor', 'revisions', 'thumbnail', 'title' )
	);

	register_post_type( 'blog', $args );
}

add_action( 'init', 'post_type_blog' );

/**
 * Post Type: Careers
 */
function post_type_careers() {
	$labels = array(
		'name'                  => _x( 'Careers', 'Post type general name', 'oph' ),
		'singular_name'         => _x( 'Career', 'Post type singular name', 'oph' ),
		'menu_name'             => _x( 'Careers', 'Admin Post text', 'oph' ),
		'name_admin_bar'        => _x( 'Careers', 'Add New on Toolbar', 'oph' ),
		'add_new'               => __( 'New Career', 'oph' ),
		'add_new_item'          => __( 'New Career', 'oph' ),
		'new_item'              => __( 'New Career', 'oph' ),
		'edit_item'             => __( 'Edit Career', 'oph' ),
		'view_item'             => __( 'View Career', 'oph' ),
		'all_items'             => __( 'All Careers', 'oph' ),
		'search_items'          => __( 'Search Careers', 'oph' ),
		'parent_item_colon'     => __( 'Parent Careers:', 'oph' ),
		'not_found'             => __( 'No careers found.', 'oph' ),
		'not_found_in_trash'    => __( 'No careers found in Trash.', 'oph' ),
		'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'oph' ),
		'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'archives'              => _x( 'Career archives', 'The post type archive label used in nav careers. Default “Post Archives”. Added in 4.4', 'oph' ),
		'insert_into_item'      => _x( 'Insert into careers', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'oph' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'oph' ),
		'filter_items_list'     => _x( 'Filter careers list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'oph' ),
		'items_list_navigation' => _x( 'Careers list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'oph' ),
		'items_list'            => _x( 'Careers list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'oph' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'careers' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-businessperson',
		'menu_position'      => null,
		'supports'           => array( 'editor', 'revisions', 'title' )
	);

	register_post_type( 'careers', $args );
}

add_action( 'init', 'post_type_careers' );

/**
 * Post Type: Grants
 */
function post_type_grants() {
	$labels = array(
		'name'                  => _x( 'Grants', 'Post type general name', 'oph' ),
		'singular_name'         => _x( 'Grants', 'Post type singular name', 'oph' ),
		'menu_name'             => _x( 'Grants', 'Admin Post text', 'oph' ),
		'name_admin_bar'        => _x( 'Grants', 'Add New on Toolbar', 'oph' ),
		'add_new'               => __( 'New Grant', 'oph' ),
		'add_new_item'          => __( 'New Grant', 'oph' ),
		'new_item'              => __( 'New Grant', 'oph' ),
		'edit_item'             => __( 'Edit Grant', 'oph' ),
		'view_item'             => __( 'View Grant', 'oph' ),
		'all_items'             => __( 'All Grants', 'oph' ),
		'search_items'          => __( 'Search Grants', 'oph' ),
		'parent_item_colon'     => __( 'Parent Grants:', 'oph' ),
		'not_found'             => __( 'No grants found.', 'oph' ),
		'not_found_in_trash'    => __( 'No grants found in Trash.', 'oph' ),
		'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'oph' ),
		'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'archives'              => _x( 'Grants archives', 'The post type archive label used in nav post. Default “Post Archives”. Added in 4.4', 'oph' ),
		'insert_into_item'      => _x( 'Insert into grant', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'oph' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this grant', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'oph' ),
		'filter_items_list'     => _x( 'Filter grant list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'oph' ),
		'items_list_navigation' => _x( 'Grants list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'oph' ),
		'items_list'            => _x( 'Grants list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'oph' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'grants' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-portfolio',
		'menu_position'      => null,
		'supports'           => array( 'author', 'editor', 'excerpt', 'revisions', 'thumbnail', 'title' )
	);

	register_post_type( 'grants', $args );
}

add_action( 'init', 'post_type_grants' );

/**
 * Post Type: Research
 */
function post_type_research() {
	$labels = array(
		'name'                  => _x( 'Research', 'Post type general name', 'oph' ),
		'singular_name'         => _x( 'Research', 'Post type singular name', 'oph' ),
		'menu_name'             => _x( 'Research', 'Admin Post text', 'oph' ),
		'name_admin_bar'        => _x( 'Research', 'Add New on Toolbar', 'oph' ),
		'add_new'               => __( 'New Research', 'oph' ),
		'add_new_item'          => __( 'New Research', 'oph' ),
		'new_item'              => __( 'New Research', 'oph' ),
		'edit_item'             => __( 'Edit Research', 'oph' ),
		'view_item'             => __( 'View Research', 'oph' ),
		'all_items'             => __( 'All Research', 'oph' ),
		'search_items'          => __( 'Search Research', 'oph' ),
		'parent_item_colon'     => __( 'Parent Posts:', 'oph' ),
		'not_found'             => __( 'No posts found.', 'oph' ),
		'not_found_in_trash'    => __( 'No posts found in Trash.', 'oph' ),
		'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'oph' ),
		'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'archives'              => _x( 'Research archives', 'The post type archive label used in nav post. Default “Post Archives”. Added in 4.4', 'oph' ),
		'insert_into_item'      => _x( 'Insert into post', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'oph' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'oph' ),
		'filter_items_list'     => _x( 'Filter post list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'oph' ),
		'items_list_navigation' => _x( 'Research list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'oph' ),
		'items_list'            => _x( 'Research list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'oph' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'research' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-index-card',
		'menu_position'      => null,
		'supports'           => array( 'author', 'editor', 'excerpt', 'revisions', 'title' )
	);

	register_post_type( 'research', $args );
}

add_action( 'init', 'post_type_research' );

/**
 * Post Type: Team
 */
function post_type_team() {
	$labels = array(
		'name'                  => _x( 'Team', 'Post type general name', 'oph' ),
		'singular_name'         => _x( 'Team', 'Post type singular name', 'oph' ),
		'menu_name'             => _x( 'Team', 'Admin Post text', 'oph' ),
		'name_admin_bar'        => _x( 'Team', 'Add New on Toolbar', 'oph' ),
		'add_new'               => __( 'New Team Member', 'oph' ),
		'add_new_item'          => __( 'New Team Member', 'oph' ),
		'new_item'              => __( 'New Team Member', 'oph' ),
		'edit_item'             => __( 'Edit Team Member', 'oph' ),
		'view_item'             => __( 'View Team Member', 'oph' ),
		'all_items'             => __( 'All Team Members', 'oph' ),
		'search_items'          => __( 'Search Team Members', 'oph' ),
		'parent_item_colon'     => __( 'Parent Team Members:', 'oph' ),
		'not_found'             => __( 'No team members found.', 'oph' ),
		'not_found_in_trash'    => __( 'No team members found in Trash.', 'oph' ),
		'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'oph' ),
		'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'oph' ),
		'archives'              => _x( 'Team archives', 'The post type archive label used in nav team members. Default “Post Archives”. Added in 4.4', 'oph' ),
		'insert_into_item'      => _x( 'Insert into team members', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'oph' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'oph' ),
		'filter_items_list'     => _x( 'Filter team members list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'oph' ),
		'items_list_navigation' => _x( 'Team Members list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'oph' ),
		'items_list'            => _x( 'Team Members list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'oph' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'about/team' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-groups',
		'menu_position'      => null,
		'supports'           => array( 'editor', 'revisions', 'thumbnail', 'title' )
	);

	register_post_type( 'team', $args );
}

add_action( 'init', 'post_type_team' );