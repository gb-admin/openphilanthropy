<?php
	$sidebar_filter = get_field( 'sidebar_filter' );

	$params = get_url_params();

	global $wpdb;

	$research_updates_authors = $wpdb->get_results( "select A.*, COUNT(*) as post_count from $wpdb->users A inner join $wpdb->posts B on A.ID = B.post_author WHERE ( ( B.post_type = 'research-updates' AND ( B.post_status = 'publish' OR B.post_status = 'private' ) ) ) GROUP BY A.ID ORDER BY post_count DESC" );
?>

<div class="sidebar-filter is-active">
	<div class="sidebar-filter__main">
		<div class="sidebar-filter-hide">
			<button class="sidebar-filter-hide-button">
				<span class="sidebar-filter-hide-button-text">Hide Options</span> <span class="sidebar-filter-hide-icon"></span>
			</button>
		</div>

		<div class="sidebar-filter__content">
			<nav aria-label="Sidebar Filter Options" data-filter-anchor="categories">
				<div class="sidebar-filter__search">
					<input type="search" placeholder="Search">

					<svg viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg"><path d="M16.478 13.675c2.273-3.305 1.94-7.862-.998-10.801-3.314-3.314-8.687-3.314-12 0-3.314 3.314-3.314 8.686 0 12 3.207 3.208 8.345 3.31 11.676.308l4.429 4.429 1.414-1.414-4.521-4.522zm-2.413-9.387c2.533 2.533 2.533 6.64 0 9.172-2.532 2.533-6.639 2.533-9.171 0-2.533-2.533-2.533-6.64 0-9.172 2.532-2.533 6.639-2.533 9.171 0z"/></svg>
				</div>

				<div class="sidebar-filter__option">
					<?php foreach ( $sidebar_filter as $filter ) : ?>
						<?php if ( $filter['filter_type'] == 'auto' ) : ?>

							<?php if ( $filter['filter_by'] == 'author' ) : ?>

								<?php
									/**
									 * Exclude authors from array.
									 */
									if ( $filter['filter_author_exclude'] ) {
										foreach ( $filter['filter_author_exclude'] as $exclude ) {
											foreach ( $research_updates_authors as $key => $author ) {
												if ( $exclude['name'] == $author->display_name ) {
													unset( $research_updates_authors[ $key ] );
												} elseif ( $exclude['name'] == $author->user_nicename ) {
													unset( $research_updates_authors[ $key ] );
												}
											}
										}
									}
								?>

								<select data-filter="author" data-input-placeholder="Type here to search ..." data-placeholder="Author">
									<option value=""></option>

									<?php foreach ( $research_updates_authors as $author ) : ?>
										<option class="<?php if ( in_array( $author->user_nicename, $params['author'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $author->user_nicename; ?>" value="<?php echo $author->display_name; ?>"><?php echo $author->display_name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php elseif ( $filter['filter_by'] == 'year' ) : ?>

								<?php
									$filter_year_range_begin = $filter['filter_year_range_begin'];
									$filter_year_range_end = $filter['filter_year_range_end'];

									if ( $filter_year_range_begin && $filter_year_range_end ) {
										$filter_years = range( $filter_year_range_begin, $filter_year_range_end );
									}
								?>

								<select data-filter="yr" data-input-placeholder="Type here to search ..." data-placeholder="Year">
									<option value=""></option>

									<?php foreach ( $filter_years as $year ) : ?>
										<option class="<?php if ( in_array( $year, $params['yr'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $year; ?>" value="<?php echo $year; ?>"><?php echo $year; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter_type'] == 'custom' ) : ?>

							<?php
								$filter_custom = [];
								$filter_custom_key = '';
								$filter_custom_no_multiple = false;
								$filter_custom_title = '';

								if ( $filter['filter_custom'] ) {
									$filter_custom = $filter['filter_custom'];
								}

								if ( $filter['filter_custom_key'] ) {
									$filter_custom_key = $filter['filter_custom_key'];
								}

								if ( $filter['filter_custom_title'] ) {
									$filter_custom_title = $filter['filter_custom_title'];
								}

								if ( $filter['filter_custom_no_multiple'] ) {
									$filter_custom_no_multiple = true;
								}
							?>

							<?php if ( ! empty( $filter_custom ) && $filter_custom_key != '' ) : ?>
								<select data-filter="<?php echo $filter_custom_key; ?>" data-input-placeholder="Type here to search ..." data-placeholder="<?php echo $filter_custom_title; ?>" data-select-multiple="<?php echo $filter_custom_no_multiple ? 'false' : 'true'; ?>">
									<option value=""></option>

									<?php foreach ( $filter_custom as $filter ) : ?>
										<?php if ( $filter['name'] && $filter['value'] ) : ?>
											<option class="<?php if ( in_array( $filter['value'], $params[ $filter_custom_key ] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $filter['value']; ?>" value="<?php echo $filter['value']; ?>"><?php echo $filter['name']; ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter_type'] == 'taxonomy' ) : ?>

							<?php
								$filter_taxonomy = get_taxonomy( $filter['filter_taxonomy'] );

								if ( $filter_taxonomy ) {
									if ( $filter_taxonomy->rewrite && $filter_taxonomy->rewrite['slug'] ) {
										$filter_taxonomy_slug = $filter_taxonomy->rewrite['slug'];
									} else {
										$filter_taxonomy_slug = $filter_taxonomy->name;
									}
								}

								$filter_terms = get_terms( array(
									'taxonomy' => $filter['filter_taxonomy']
								) );
							?>

							<?php if ( $filter_taxonomy_slug ) : ?>
								<select data-filter="<?php echo $filter_taxonomy_slug; ?>" data-input-placeholder="Type here to search ..." data-placeholder="<?php echo $filter_taxonomy->label; ?>">
									<option value=""></option>

									<?php foreach ( $filter_terms as $term ) : ?>
										<option class="<?php if ( in_array( $term->slug, $params[ $filter_taxonomy_slug ] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $term->slug; ?>" value="<?php echo $term->name; ?>"><?php echo $term->name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<div class="sidebar-filter__button">
					<a class="button" href="#">Download Spreadsheet</a>
				</div>
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