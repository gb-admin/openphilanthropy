<?php
/**
 * Enqueue scripts and styles.
 */
function enqueue_asset() {
	// wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap', array(), null );

	wp_enqueue_style( 'jquery-bundle-style', get_template_directory_uri() . '/ui/css/jquery.bundle.css' );

	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/ui/css/main.min.css' );

	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/ui/css/custom.css', array(), '1.0.1' );

	wp_enqueue_script( 'jquery-bundle-script', get_template_directory_uri() . '/ui/js/jquery.bundle.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/ui/js/main.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/ui/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_asset' );