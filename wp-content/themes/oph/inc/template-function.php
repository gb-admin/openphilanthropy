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
			$param .= '=';
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

/**
 * Classic editor - Adding subscript and superscript
 * Adding in core buttons that's disabled by default
 */

function oph_adding_sub_sup_buttons_to_editor($buttons) {  
    // $buttons[] = 'subscript';
    $buttons[] = 'superscript';
    return $buttons;
}
add_filter('mce_buttons_2', 'oph_adding_sub_sup_buttons_to_editor');


// Determine the top-most parent of a term
function get_term_top_most_parent( $term, $taxonomy ) {
    // Start from the current term
    $parent  = get_term( $term, $taxonomy );
    // Climb up the hierarchy until we reach a term with parent = '0'
    while ( $parent->parent != '0' ) {
        $term_id = $parent->parent;
        $parent  = get_term( $term_id, $taxonomy);
    }
    return $parent;
}

// Add the search function to the navigation menu
add_filter( 'wp_nav_menu_items', 'oph_add_search_functionality', 10, 2 );
function oph_add_search_functionality ( $items, $args ) {
    if ( $args->theme_location == 'primary') { 
		ob_start(); ?>
        <li id='sitewide-search'>
			<a href='javascript:void(0)' id='sitewide-search-button'>
				<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M15.4837 13.2867C17.7568 9.98148 17.4241 5.42387 14.4855 2.48532C11.1718 -0.82844 5.79908 -0.82844 2.48532 2.48532C-0.82844 5.79908 -0.82844 11.1718 2.48532 14.4855C5.69318 17.6934 10.8305 17.7959 14.1616 14.7931L18.5908 19.2222L20.005 17.808L15.4837 13.2867ZM13.0713 3.89953C15.604 6.43225 15.604 10.5386 13.0713 13.0713C10.5386 15.604 6.43225 15.604 3.89953 13.0713C1.36682 10.5386 1.36682 6.43225 3.89953 3.89953C6.43225 1.36682 10.5386 1.36682 13.0713 3.89953Z" fill="white"/>
				</svg>
			</a>
		</li>
		<?php $items .= ob_get_clean();
    }
    return $items;
}

/**
 * Recursively get taxonomy and its children
 *
 * @param string $taxonomy
 * @param int $parent - parent term id
 * @return array
 */
function get_taxonomy_hierarchy( $taxonomy, $parent = 0, $post_type = '' ) {
	$children = array();

	$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;

	$args['parent'] = $parent;
	if ( $post_type ) {
		// By default get_terms does not accept post_type param, this is added via oph_terms_clauses function below
		$args['post_type'] = $post_type; 
	}

	$terms = get_terms( $taxonomy, $args );

	foreach ( $terms as $term ) {
		$term->children = get_taxonomy_hierarchy( $taxonomy, $term->term_id, $post_type );

		$children[ $term->term_id ] = $term;
	}

	return $children;
}

/**
 * Extend get terms with post type parameter.
 * @link https://dfactory.eu/wp-how-to-get-terms-post-type/
 *
 * @global $wpdb
 * @param string $clauses
 * @param string $taxonomy
 * @param array $args
 * @return string
 */
function oph_terms_clauses( $clauses, $taxonomy, $args ) {
	if ( isset( $args['post_type'] ) && ! empty( $args['post_type'] ) && $args['fields'] !== 'count' ) {
		global $wpdb;

		$post_types = array();

		if ( is_array( $args['post_type'] ) ) {
			foreach ( $args['post_type'] as $cpt ) {
				$post_types[] = "'" . $cpt . "'";
			}
		} else {
			$post_types[] = "'" . $args['post_type'] . "'";
		}

		if ( ! empty( $post_types ) ) {
			$clauses['fields'] = 'DISTINCT ' . str_replace( 'tt.*', 'tt.term_taxonomy_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields'] ) . ', COUNT(p.post_type) AS count';
			$clauses['join'] .= ' LEFT JOIN ' . $wpdb->term_relationships . ' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN ' . $wpdb->posts . ' AS p ON p.ID = r.object_id';
			$clauses['where'] .= ' AND (p.post_type IN (' . implode( ',', $post_types ) . ') OR p.post_type IS NULL)';
			$clauses['orderby'] = 'GROUP BY t.term_id ' . $clauses['orderby'];
		}
	}
	return $clauses;
}

add_filter( 'terms_clauses', 'oph_terms_clauses', 10, 3 );

// Setting grid or list view
function oph_display_type($default_view='list') {
	$view_text = [
		'list'	=> 'View as Grid',
		'grid'	=> 'View as List'
	];

	// None set, use default
	if ( !isset($_GET['view-list']) ) return $view_text[$default_view];

	// Is set, return the corresponding text
	return ( $_GET['view-list'] == "true" ) ? $view_text['list'] : $view_text['grid'];
}