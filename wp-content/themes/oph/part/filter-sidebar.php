<?php
	$post_type = '';

	if ( isset( $args['post_type'] ) ) {
		$post_type = $args['post_type'];
	}

	$sidebar_filter = get_field( 'sidebar_filter' );

	$params = get_url_params();

	global $wpdb;

	// Loading in official WP Users that have posts in post_type research
	// $official_research_authors = $wpdb->get_results( "select A.*, COUNT(*) as post_count from $wpdb->users A inner join $wpdb->posts B on A.ID = B.post_author WHERE ( ( B.post_type = 'research' AND ( B.post_status = 'publish' OR B.post_status = 'private' ) ) ) GROUP BY A.ID ORDER BY post_count DESC" );

	// Loading unofficial custom authors (added in metabox -> postmeta)
	// $custom_research_authors = oph_get_all_custom_authors();

	// Merging the two together
	// $research_authors = oph_merge_all_research_authors($official_research_authors, $custom_research_authors);


	$content_type = get_terms( array(
		'taxonomy' => 'content-type'
	) );

	// $focus_area = get_taxonomy_hierarchy( 'focus-area', $parent=0, $post_type );

	$focus_area = get_terms( array(
		'taxonomy' => 'focus-area'
	) );

	// // Flatten hierarchy taxonomy array
	// foreach ( $focus_area as $k => $tax ) {
	// 	if ( isset( $tax->children ) && ! empty( $tax->children ) ) {

	// 		// Flatten
	// 		array_splice( $focus_area, 2, 0, $tax->children );

	// 		// Unset original
	// 		$tax->children = [];
	// 	}
	// }

	$funding_type = get_terms( array(
		'taxonomy' => 'funding-type'
	) );

	$organization_name = get_terms( array(
		'taxonomy' => 'organization-name'
	) );

	$grants = '';

	$grants_years = [];

	$grants = new WP_Query( array(
		'post_type' => 'grants',
		'posts_per_page' => -1,
		'order' => 'desc',
		'orderby' => 'date'
	) );

	if ( $grants && $grants->posts ) {
		$grants_posts = $grants->posts;

		foreach ( $grants_posts as $i ) {
			$post_year = get_field( 'award_date', $i->ID );

			// Return format is word-formatted - get year from last 4 characters.
			$post_year = substr( $post_year, -4 );

			array_push( $grants_years, $post_year );
		}
	}

	$grants_years = array_unique( $grants_years );

	rsort( $grants_years );  

	$sort_authors = array(); 

	$research_posts = new WP_Query(
		array(
			'post_type' => 'research',
			'posts_per_page' => -1
		)
	); 

	if ( $research_posts && $research_posts->posts ) {
		$authors_sortable = $research_posts->posts; 

		foreach ( $authors_sortable as $i ) {
			$displayAuthor = get_post_meta($i->ID, 'custom_author', true); 
			array_push( $sort_authors, $displayAuthor ); 
		}
	}
	$sort_authors = array_unique( $sort_authors ); 
	sort( $sort_authors ); 

?>

<div class="sidebar-filter">
	<div class="sidebar-filter__main">
		<div class="sidebar-filter-hide">
			<button class="sidebar-filter-hide-button">
				<span class="sidebar-filter-hide-button-text">Hide Options</span> <span class="sidebar-filter-hide-icon"></span>
			</button>
		</div>

		<div class="sidebar-filter__content">
			<nav aria-label="Sidebar Filter Options" data-filter-anchor="categories">
				<div class="sidebar-filter__search">

					<?php
						if ( $post_type ) {
							if ( $post_type == 'grants' ) {
								get_template_part( 'searchform', 'grants' );
							} elseif ( $post_type == 'research' ) {
								get_template_part( 'searchform', 'research' );
							}
						} else {
							get_template_part( 'searchform' );
						}
					?>
				</div>

				<div class="sidebar-filter__option">
					<?php foreach ( $sidebar_filter as $filter ) : ?>
						<?php if ( $filter['filter'] == 'amount' ) : ?>
							<select data-filter="amount" data-input-placeholder="Type here to search ..." data-placeholder="Amount">
								<option value=""></option>

								<option class="<?php if ( in_array( 'less-than-1hundthous', $params['amount'] ) ) { echo 'category-selected'; } ?>" data-category="less-than-1hundthous" value="Less than $100,000">Less than $100,000</option>
								<option class="<?php if ( in_array( 'between-1hundthous-1mil', $params['amount'] ) ) { echo 'category-selected'; } ?>" data-category="between-1hundthous-1mil" value="Between $100,000 and $1,000,000">Between $100,000 and $1,000,000</option>
								<option class="<?php if ( in_array( 'greater-than-1mil', $params['amount'] ) ) { echo 'category-selected'; } ?>" data-category="greater-than-1mil" value="Greater than $1,000,000">Greater than $1,000,000</option>
							</select>
						<?php elseif ( $filter['filter'] == 'author' ) : ?>

							<?php
								/**
								 * Exclude authors from array.
								 */
								// if ( isset( $filter['filter_author_exclude'] ) ) {
								// 	foreach ( $filter['filter_author_exclude'] as $exclude ) {
								// 		foreach ( $research_authors as $key => $author ) {
								// 			if ( $exclude['name'] == $author->display_name ) {
								// 				unset( $research_authors[ $key ] );
								// 			} elseif ( $exclude['name'] == $author->user_nicename ) {
								// 				unset( $research_authors[ $key ] );
								// 			}
								// 		}
								// 	}
								// }
							?>

							<select data-filter="author" data-input-placeholder="Type here to search ..." data-placeholder="Author">
								<option value=""></option>

								<?php foreach ( $sort_authors as $author ) : ?>
									<option class="<?php if ( in_array( $author, $params['author'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $author; ?>" value="<?php echo $author; ?>"><?php echo $author; ?></option>
								<?php endforeach; ?>
							</select>
						<?php elseif ( $filter['filter'] == 'content-type' ) : ?>

							<?php if ( $content_type ) : ?>
								<select data-filter="content-type" data-input-placeholder="Type here to search ..." data-placeholder="Content Type">
									<option class="filler-option" value=""></option>

									<?php foreach ( $content_type as $i ) : ?>
										<option class="<?php if ( in_array( $i->slug, $params['content-type'] ) ) { echo 'category-selected'; } if ( $i->parent != 0 ) { echo ' is-term-child'; } ?>" data-category="<?php echo $i->slug; ?>" data-parent="<?php echo $i->parent ?>" data-termID="<?php echo $i->term_id ?>" value="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter'] == 'focus-area' ) : ?>

							<?php if ( $focus_area ) : ?>
								<select data-filter="focus-area" data-input-placeholder="Type here to search ..." data-placeholder="Focus Area">
									<option class="filler-option" value=""></option>

									<?php foreach ( $focus_area as $i ) : ?>
										<option class="<?php if ( in_array( $i->slug, $params['focus-area'] ) ) { echo 'category-selected'; } if ( $i->parent != 0 ) { echo ' is-term-child'; } ?>" data-category="<?php echo $i->slug; ?>" data-parent="<?php echo $i->parent ?>" data-termID="<?php echo $i->term_id ?>" value="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter'] == 'funding-type' ) : ?>

							<?php if ( $funding_type ) : ?>
								<select data-filter="funding-type" data-input-placeholder="Type here to search ..." data-placeholder="Funding Type">
									<option value=""></option>

									<?php foreach ( $funding_type as $i ) : ?>
										<option class="<?php if ( in_array( $i->slug, $params['funding-type'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $i->slug; ?>" value="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter'] == 'organization-name' ) : ?>

							<?php if ( $organization_name ) : ?>
								<select data-filter="organization-name" data-input-placeholder="Type here to search ..." data-placeholder="Organization Name">
									<option value=""></option>

									<?php foreach ( $organization_name as $i ) : ?>
										<option class="<?php if ( in_array( $i->slug, $params['organization-name'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $i->slug; ?>" value="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter'] == 'year' ) : ?>
							<?php if ( $grants_years ) : ?>
								<select data-filter="yr" data-input-placeholder="Type here to search ..." data-placeholder="Year">
									<option value=""></option>

									<?php foreach ( $grants_years as $year ) : ?>
										<option class="<?php if ( in_array( $year, $params['yr'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $year; ?>" value="<?php echo $year; ?>"><?php echo $year; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<div class="sidebar-filter__button">
					<a href='javascript:void(0);' class="button sidebar-filter__submit">Submit</a>
				</div>

				<?php if ( is_page('grants') ) : ?>
				<div class="sidebar-filter__button sidebar-filter__download">
					<?php
					  $nonce = wp_create_nonce("generate_grants_csv_nonce");
					  $link = admin_url('admin-ajax.php?action=generate_grants&nonce='.$nonce);
					  echo '<a class="button" data-nonce="' . $nonce . '" href="' . $link . '">Download Spreadsheet</a>';
					?>
				</div>
				<?php endif; ?>
			</nav>
		</div>

		<div class="sidebar-filter-show-button-container">
			<button class="sidebar-filter-show-button">Show Options</button>
		</div>
	</div>
</div>

<div class="sidebar-filter-show-button-container mobile-only">
	<button class="sidebar-filter-show-button">Show Options</button>
</div>