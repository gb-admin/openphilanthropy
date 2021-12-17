<?php
add_action( 'init',  'oph_db_grants_download_add_endpoint');
function oph_db_grants_download_add_endpoint() {
	add_rewrite_rule( 
		'grants/download-(spreadsheet)[/]?$',
		'index.php?pagename=grants&download=$matches[1]', 
		'top'
	);
}

add_filter('query_vars', 'oph_db_grants_download_query_vars');
function oph_db_grants_download_query_vars($query_vars) {
	$query_vars[] = 'download';
	return $query_vars;
}

// Loading a bit later to wait for the query var to be set
add_action('wp', 'oph_db_grants_download_spreadsheet');

function oph_db_grants_download_spreadsheet() {
	global $wp_query;
	$filename = "grants_db.csv";

	if (isset($wp_query->query_vars['download']) && $wp_query->query_vars['download'] == 'spreadsheet') {
		if ( !isset($_POST['grants_query']) ) exit("No data to download");

		$grants_query = unserialize(base64_decode($_POST['grants_query']));
		$grants_posts = $grants_query->posts;

		$file = create_csv($grants_posts);
		header('Content-Type: text/csv');
 		// tell the browser we want to save it instead of displaying it
 		header('Content-Disposition: attachment; filename="'.$filename.'";');

		// make php send the generated csv lines to the browser
		fpassthru($file);
		exit;
	}
}

function create_csv($grants_posts) {
	/**
	 * Export data to CSV.
	 */
	$file = fopen('php://memory', 'w'); 

	fputcsv( $file, array( 'Grant', 'Organization Name', 'Focus Area', 'Amount', 'Date' ) );

	$csv = [];

	foreach ( $grants_posts as $i ) {
		$post_grant_amount = get_field( 'grant_amount', $i->ID );
		$post_grant_date = get_the_date( 'm/Y' );
		$post_grant_focus_area = get_the_terms( $i->ID, 'focus-area' );
		$post_grant_organization_name = get_the_terms( $i->ID, 'organization-name' );
		$post_grant_title = get_the_title( $i->ID );

		if ( $post_grant_amount ) {
			$post_grant_amount = '$' . number_format( $post_grant_amount );
		} else {
			$post_grant_amount = '';
		}

		if ( $post_grant_date ) {
			$post_grant_date = ltrim( $post_grant_date, '0' );
		} else {
			$post_grant_date = '';
		}

		if ( $post_grant_focus_area && ! is_wp_error( $post_grant_focus_area ) && isset( $post_grant_focus_area[0] ) ) {
			if ( isset( $post_grant_focus_area[0]->name ) ) {
				$post_grant_focus_area = $post_grant_focus_area[0]->name;
			}
		} else {
			$post_grant_focus_area = '';
		}

		if ( $post_grant_organization_name && ! is_wp_error( $post_grant_organization_name ) && isset( $post_grant_organization_name[0] ) ) {
			if ( isset( $post_grant_organization_name[0]->name ) ) {
				$post_grant_organization_name = $post_grant_organization_name[0]->name;
			}
		} else {
			$post_grant_organization_name = '';
		}

		if ( $post_grant_title ) {
			$line = [ $post_grant_title, $post_grant_organization_name, $post_grant_focus_area, $post_grant_amount, $post_grant_date ];

			array_push( $csv, $line );
		}
	}

	foreach ( $csv as $row ) {
		fputcsv( $file, $row );
	}

	// reset the file pointer to the start of the file
	fseek($file, 0);
	return $file;
}