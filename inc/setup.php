<?php
/**
 * Add image size.
 */
add_image_size( 'xs', 320, 320 );
add_image_size( 'sm', 768, 768 );
add_image_size( 'md', 1024, 1024 );
add_image_size( 'lg', 1440, 1440 );
add_image_size( 'xl', 2048, 2048 );
add_image_size( 'xs-square', 320, 320, true );
add_image_size( 'sm-square', 768, 768, true );
add_image_size( 'md-square', 1024, 1024, true );
add_image_size( 'lg-square', 1440, 1440, true );
add_image_size( 'xl-square', 2048, 2048, true );

/**
 * Rewrite post type for pagination.
 */
function setup_rewrite_post_type_pagination() {
	global $wp_post_types;

	foreach ( $wp_post_types as $wp_post_type ) {
		$slug = isset( $wp_post_type->rewrite['slug'] ) ? $wp_post_type->rewrite['slug'] : $wp_post_type->name;

		add_rewrite_rule('^' . $slug . '/page/([0-9]+)','index.php?pagename=' . $slug . '&paged=$matches[1]', 'top');
	}
};

add_action( 'init', 'setup_rewrite_post_type_pagination', 20 );

/**
 * Admin CSS.
 */
function setup_admin_style() {
	wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/ui/css/admin.min.css' );
}

add_action( 'admin_enqueue_scripts', 'setup_admin_style' );

/**
 * Remove Categories and Tags.
 */
function setup_remove_taxonomy() {
	register_taxonomy( 'category', array() );
	register_taxonomy( 'post_tag', array() );
}

add_action( 'init', 'setup_remove_taxonomy' );

/**
 * Remove menu item.
 *
 * Posts.
 */
function setup_remove_menu_item() { 
	remove_menu_page( 'edit.php' );
}

add_action( 'admin_menu', 'setup_remove_menu_item' );

/**
 * Remove unnecessary menus.
 */
function setup_remove_unnecessary_menus() {
	global $submenu;

	foreach ( $submenu['themes.php'] as $menu_index => $theme_menu ) {
		if ( $theme_menu[0] == 'Header' || $theme_menu[0] == 'Background' ) {
			unset( $submenu['themes.php'][ $menu_index ] );
		}
	}
}

add_action( 'admin_menu', 'setup_remove_unnecessary_menus', 999 );

/**
 * Remove h1 from WordPress editor.
 *
 * @param array $settings The array of editor settings
 *
 * @return array The modified edit settings
 */
function setup_tinymce_remove_h1( $settings ) {
	$settings['block_formats'] = 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre;';

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'setup_tinymce_remove_h1' );

/**
 * Login Logo.
 *
 * Use the file login-logo.png as logo.
 */
function setup_login_logo() {
	echo '<style> h1 a { margin-bottom: 32px !important; width: 100% !important; height: 72px !important; background-image: url(' . get_template_directory_uri() . '/ui/img/login-logo.png) !important; background-position: center !important; background-size: contain !important; } </style>';
}

add_action( 'login_head', 'setup_login_logo' );

/**
 * Login style.
 *
 * Add additional style.
 */
function setup_login_style() {
	echo '<style>body.login { background: #263046; color: #fff; } body.login a { color: #fff !important; text-decoration: none !important; } body.login a:hover { text-decoration: underline !important; } body.login form, body.login .message, body.login #login_error { color: #263046; } #wp-auth-check-wrap #wp-auth-check { background-color: #263046; } #wp-auth-check-wrap #wp-auth-check .wp-auth-check-close { color: #fff; }</style>';
}

add_action( 'login_head', 'setup_login_style' );

/**
 * Collapse Postbox.
 */
function setup_acf_collapse_fields() {
	?>

	<script type="text/javascript">
		( function( $ ) {
			$( window ).on( 'load', function() {
				$( '#normal-sortables .postbox' ).not( '.post-type-acf-field-group .postbox' ).addClass( 'closed' );
			} );
		} )( jQuery );
	</script>

	<?php
}

add_action( 'acf/input/admin_head', 'setup_acf_collapse_fields' );

/**
 * Remove Comments.
 */

// Remove from admin menu
function setup_remove_menu_page_comments() {
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'setup_remove_menu_page_comments' );

// Remove from post and pages
function setup_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}

add_action( 'init', 'setup_remove_comment_support', 100 );

// Remove from admin bar
function setup_remove_admin_bar_comments() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'comments' );
}

add_action( 'wp_before_admin_bar_render', 'setup_remove_admin_bar_comments' );