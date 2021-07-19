<?php
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function oph_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'oph_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function oph_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'oph_pingback_header' );

/**
 * Excerpt.
 *
 * @param array $args {
 *     Optional. Array of excerpt() arguments.
 *
 *     @type int    $limit   Limit result to amount. Default '55'.
 *     @type string $limitby Limit by either word or character. Default 'word'. Accepts 'char', 'word'.
 *     @type string $append  Append a string to the excerpt. Default null.
 *     @type string $source  Source to use for the excerpt. Default get_the_excerpt().
 * }
 *
 * @return string $excerpt String of the resulting excerpt.
 *
 * @example
 *    $excerpt = array(
 *        'append'  => '...',
 *        'limit'   => 55,
 *        'limitby' => 'char',
 *        'source'  => $source
 *    );
 */
function excerpt( $args = null ) {
	$defaults = array(
		'append' => null,
		'limit' => 55,
		'limitby' => 'word',
		'source' => get_the_excerpt()
	);

	$args = wp_parse_args( $args, $defaults );

	$excerpt = $args['source']; // Excerpt equal to $source argument
	$excerpt = strip_shortcodes( $excerpt ); // Strip shortcodes
	$excerpt = strip_tags( $excerpt ); // Strip tags
	$excerpt = str_replace( array( '&nbsp;' ), ' ', $excerpt ); // Replace forced space with single space

	// Limit by character if excerpt length greater than limit
	if ( $args['limitby'] == 'char' && strlen( $excerpt ) > $args['limit'] ) {
		$excerpt = preg_replace( '(\[.*?\])', '', $excerpt );
		$excerpt = substr( $excerpt, 0, $args['limit'] );
		$excerpt = substr( $excerpt, 0, strripos( $excerpt, ' ' ) );
		$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
		$excerpt = $excerpt . $args['append'];

	// Limit by word if excerpt length greater than limit
	} elseif ( $args['limitby'] == 'word' && str_word_count( $excerpt ) > $args['limit'] ) {
		$excerpt = preg_replace( '/\s+/', ' ', $excerpt ); // Replace multiple spaces into single space
		$excerpt = explode( ' ', $excerpt, $args['limit'] + 1 );

		array_pop( $excerpt );

		$excerpt = implode( ' ', $excerpt );
		$excerpt = $excerpt . $args['append'];
	}

	return $excerpt;
}

function get_url_params() {
	$query = explode( '&', $_SERVER['QUERY_STRING'] );

	$params = array();

	foreach ( $query as $param ) {
		if ( strpos( $param, '=' ) === false ) {
			$param += '=';
		}

		list( $name, $value ) = explode( '=', $param, 2 );

		$params[ urldecode( $name ) ][] = urldecode( $value );
	}

	return $params;
}

/**
 * Inline List.
 */
function inline_list( $list, $separator = ', ', $prefix = null ) {
	if ( $list ) {
		if ( is_array( $list ) ) {
			$list = implode( $separator, $list );
		}

		$list = preg_replace( '/\s+/', ' ', $list ); // Replace multiple space with single space
		$list = trim( $list );

		if ( $prefix ) {
			$list = explode( ' ', $list );

			foreach ( $list as &$item ) {
				$item = $prefix . $item;
			}

			unset( $item );

			$list = implode( $separator, $list );
		}

		return $list;
	}
}

/**
 * Pagination.
 */
function pagination( $pages = '', $range = 4 ) {
	global $paged;

	$showitems = ( $range * 2 ) + 1;

	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( $pages == '' ) {
		global $wp_query;

		$pages = $wp_query->max_num_pages;

		if ( ! $pages ) {
			$pages = 1;
		}
	}

	if ( $pages != 1 ) {
		echo '<div class="pagination"><span class="pagination__label">Page:</span>';

		// Easy arrows
		// &laquo; First
		// Last &raquo;
		// Next &rsaquo;
		// &lsaquo; Previous

		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
			echo "<a href='" . get_pagenum_link( 1 ) . "'>&laquo; First</a>";
		}

		if ( is_paged() ) {
			echo '<a class="pagination__move pagination__back" href="' . get_pagenum_link( $paged - 1 ) . '"><span class="screen-reader-text">Previous</span><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 10"><path d="M5.365 0L7 1.53 3.293 5 7 8.47 5.365 10 0 5z"/></svg></a>';
		}

		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( $pages != 1 && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				echo ( $paged == $i ) ? '<span class="pagination__current pagination__number">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '" class="pagination__inactive pagination__number">' . $i . '</a>';
			}
		}

		if ( $paged < ( $i - 1 ) ) {
			echo '<a class="pagination__move pagination__next" href="' . get_pagenum_link( $paged + 1 ) . '"><span class="screen-reader-text">Next</span><svg aria-hidden="true" viewBox="0 0 8 13" xmlns="http://www.w3.org/2000/svg"><path d="M1.868 0L0 1.99 4.237 6.5 0 11.01 1.868 13 8 6.5z"/></svg></a>';
		}

		// if ( $paged < $pages - 1 &&  $paged + $range - 1 < $pages && $showitems < $pages ) {
		// 	echo "<a href='" . get_pagenum_link( $pages ) . "'>Last</a>";
		// }

		echo "</div>\n";
	}
}

/**
 * Set object terms from toggle field.
 */
function toggle_taxonomy( $args ) {
	$defaults = array(
		'post_type'    => 'post',
		'taxonomy'     => 'category',
		'terms_false'  => null,
		'terms_true'   => null,
		'toggle_field' => null
	);

	$args = wp_parse_args( $args, $defaults );

	if ( $args['toggle_field'] ) {
		$toggle_posts = get_posts( array(
			'numberposts' => -1,
			'post_type' => $args['post_type']
		) );

		if ( $toggle_posts ) {
			foreach ( $toggle_posts as $p ) {
				$has_field = get_field( $args['toggle_field'], $p->ID );

				if ( $has_field || $args['toggle_field'] === 1 ) {
					wp_set_object_terms( $p->ID, $args['terms_true'], $args['taxonomy'] );
				} else {
					wp_set_object_terms( $p->ID, $args['terms_false'], $args['taxonomy'] );
				}
			}
		}
	}
}