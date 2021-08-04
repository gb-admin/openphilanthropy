<?php
	$post_type = '';

	if ( $args['post_type'] ) {
		$post_type = $args['post_type'];
	}

	$sidebar_filter = get_field( 'sidebar_filter' );

	$params = get_url_params();

	global $wpdb;

	$research_authors = $wpdb->get_results( "select A.*, COUNT(*) as post_count from $wpdb->users A inner join $wpdb->posts B on A.ID = B.post_author WHERE ( ( B.post_type = 'research' AND ( B.post_status = 'publish' OR B.post_status = 'private' ) ) ) GROUP BY A.ID ORDER BY post_count DESC" );

	$content_type = get_terms( array(
		'taxonomy' => 'content-type'
	) );

	$focus_area = get_terms( array(
		'taxonomy' => 'focus-area'
	) );

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
			$post_year = get_the_date( 'Y', $i->ID );

			array_push( $grants_years, $post_year );
		}
	}

	$grants_years = array_unique( $grants_years );
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
								if ( isset( $filter['filter_author_exclude'] ) ) {
									foreach ( $filter['filter_author_exclude'] as $exclude ) {
										foreach ( $research_authors as $key => $author ) {
											if ( $exclude['name'] == $author->display_name ) {
												unset( $research_authors[ $key ] );
											} elseif ( $exclude['name'] == $author->user_nicename ) {
												unset( $research_authors[ $key ] );
											}
										}
									}
								}
							?>

							<select data-filter="author" data-input-placeholder="Type here to search ..." data-placeholder="Author">
								<option value=""></option>

								<?php foreach ( $research_authors as $author ) : ?>
									<option class="<?php if ( in_array( $author->user_nicename, $params['author'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $author->user_nicename; ?>" value="<?php echo $author->display_name; ?>"><?php echo $author->display_name; ?></option>
								<?php endforeach; ?>
							</select>
						<?php elseif ( $filter['filter'] == 'content-type' ) : ?>

							<?php if ( $content_type ) : ?>
								<select data-filter="content-type" data-input-placeholder="Type here to search ..." data-placeholder="Content Type">
									<option value=""></option>

									<?php foreach ( $content_type as $i ) : ?>
										<option class="<?php if ( in_array( $i->slug, $params['content-type'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $i->slug; ?>" value="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						<?php elseif ( $filter['filter'] == 'focus-area' ) : ?>

							<?php if ( $focus_area ) : ?>
								<select data-filter="focus-area" data-input-placeholder="Type here to search ..." data-placeholder="Focus Area">
									<option value=""></option>

									<?php foreach ( $focus_area as $i ) : ?>
										<option class="<?php if ( in_array( $i->slug, $params['focus-area'] ) ) { echo 'category-selected'; } ?>" data-category="<?php echo $i->slug; ?>" value="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
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
					<a class="button" href="<?php echo get_stylesheet_directory() . '/grants_db.csv'; ?>" download="grants_db.csv">Download Spreadsheet</a>
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