<?php
	/**
	 * Template Name: Grants
	 */

	the_post();

	get_header();

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	$params = get_url_params();

	$featured_grants = get_field( 'featured_grants' );

	$featured_grants_id = [];

	if ( $featured_grants ) {
		array_push( $featured_grants_id, $featured_grants->ID );
	}

	$amount_meta_query = array(
		'relation' => 'or'
	);

	$date_query = array(
		'relation' => 'or'
	);

	$tax_query = array(
		'relation' => 'or'
	);

	foreach ( $params as $key => $param ) {
		if ( $key == 'amount' ) {
			foreach ( $param as $value ) {
				if ( $value == 'less-than-1hundthous' ) {
					$param_amount_meta_query = array(
						'key' => 'grant_amount',
						'value' => 100000,
						'compare' => '<',
						'type' => 'numeric'
					);
				} elseif ( $value == 'between-1hundthous-1mil' ) {
					$param_amount_meta_query = array(
						'key' => 'grant_amount',
						'value' => array( 100000, 1000000 ),
						'compare' => 'between',
						'type' => 'numeric'
					);
				} elseif ( $value == 'greater-than-1mil' ) {
					$param_amount_meta_query = array(
						'key' => 'grant_amount',
						'value' => 1000000,
						'compare' => '>',
						'type' => 'numeric'
					);
				}

				array_push( $amount_meta_query, $param_amount_meta_query );
			}
		} elseif ( $key == 'yr' ) {
			foreach ( $param as $value ) {
				$param_date_query = array(
					'year' => $value
				);

				array_push( $date_query, $param_date_query );
			}
		} else {

			// Get taxonomy by $key which is the rewrite
			$taxonomy = get_taxonomy( $key );

			// Check if get taxonomy with post type prepended in case it was rewrite
			if ( ! $taxonomy ) {
				$taxonomy = get_taxonomy( 'grants-' . $key );
			}
		}

		if ( $taxonomy ) {
			foreach ( $param as $value ) {
				$param_query = array(
					'taxonomy' => $taxonomy->name,
					'terms' => $value,
					'field' => 'slug'
				);

				array_push( $tax_query, $param_query );
			}
		}
	}

	$grants = new WP_Query( array(
		'post_type' => 'grants',
		'posts_per_page' => 9,
		'order' => 'desc',
		'orderby' => 'date',
		'paged' => $paged,
		'post__not_in' => $featured_grants_id,
		'date_query' => $date_query,
		'meta_query' => $amount_meta_query,
		'tax_query' => $tax_query
	) );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<?php get_template_part( 'part/page', 'header-categories' ); ?>

<div class="feed-section">
	<div class="feed-options-bar">
		<div class="wrap">
			<nav aria-label="Feed Options Bar">
				<div class="dropdown">
					<button class="button" href="#">
						Sort <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
					</button>

					<ul class="dropdown-content">
						<li>
							<a href="#high-to-low">Highest to lowest</a>
						</li>
						<li>
							<a href="#a-to-z">A to Z</a>
						</li>
						<li>
							<a href="#recent">Newest to oldest</a>
						</li>
					</ul>
				</div>

				<div class="dropdown dropdown--inline-content">
					<button class="button" href="#">
						Items <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
					</button>

					<ul class="dropdown-content">
						<li>
							<a href="#25">25</a>
						</li>
						<li>
							<a href="#50">50</a>
						</li>
						<li>
							<a href="#100">100</a>
						</li>
					</ul>
				</div>

				<button class="button button--solid">View all as list</button>
			</nav>
		</div>
	</div>

	<div class="feed-section__content">
		<?php get_template_part( 'part/filter', 'sidebar' ); ?>

		<div class="feed-options-bar feed-options-bar--mobile">
			<div class="wrap">
				<nav aria-label="Feed Options Bar">
					<div class="dropdown">
						<button class="button" href="#">
							Sort <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
						</button>

						<ul class="dropdown-content">
							<li>
								<a href="#high-to-low">Highest to lowest</a>
							</li>
							<li>
								<a href="#a-to-z">A to Z</a>
							</li>
							<li>
								<a href="#recent">Newest to oldest</a>
							</li>
						</ul>
					</div>

					<div class="dropdown dropdown--inline-content">
						<button class="button" href="#">
							Items <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
						</button>

						<ul class="dropdown-content">
							<li>
								<a href="#25">25</a>
							</li>
							<li>
								<a href="#50">50</a>
							</li>
							<li>
								<a href="#100">100</a>
							</li>
						</ul>
					</div>

					<button class="button button--solid">View all as list</button>
				</nav>
			</div>
		</div>

		<div class="feed-section__posts wrap">
			<?php if ( $grants->have_posts() ) : ?>
				<div class="block-feed block-feed--images">
					<?php while ( $grants->have_posts() ) : $grants->the_post(); ?>

						<?php
							$grant_amount = get_field( 'grant_amount' );
							$grants_content_type = get_the_terms( $post->ID, 'grants-content-type' );
							$grants_focus_area = get_the_terms( $post->ID, 'grants-focus-area' );
							$grants_funding_type = get_the_terms( $post->ID, 'grants-funding-type' );
							$post_thumbnail = get_the_post_thumbnail_url( $post->ID, 'lg' );

							if ( ! $post_thumbnail ) {
								$post_thumbnail = get_field( 'category_image', 'grants-funding-type_' . $grants_funding_type[0]->term_id )['sizes']['lg'];
							}
						?>

						<div class="block-feed-post<?php if ( ! $post_thumbnail ) { echo ' no-thumbnail'; } ?>">
							<h5 class="block-feed-post__date">
								<?php echo get_the_date( 'F j, Y', $grants->ID ); ?>
							</h5>

							<div class="block-feed-post__head">
								<?php if ( $post_thumbnail ) : ?>
									<a href="<?php echo the_permalink(); ?>">
										<img src="<?php echo $post_thumbnail; ?>" alt="">
									</a>
								<?php endif; ?>
							</div>

							<div class="block-feed-post__body">
								<h4>
									<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
								</h4>

								<?php if ( $grants_focus_area && ! is_wp_error( $grants_focus_area ) ) : ?>
									<h5>
										<a href="?focus-area=<?php echo $grants_focus_area[0]->slug; ?>#categories"><?php echo $grants_focus_area[0]->name; ?></a>
									</h5>
								<?php endif; ?>

								<?php if ( $grant_amount ) : ?>
									<h5><?php echo '$' . number_format( $grant_amount ); ?></h5>
								<?php endif; ?>

								<div class="block-feed-post__link">
									<a href="<?php echo the_permalink(); ?>">
										Learn more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
									</a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<h3 style="padding: 36px 0; text-align: center;">No posts found matching criteria.</h3>
			<?php endif; ?>

			<div class="feed-footer">
				<nav aria-label="Post Feed Pagination" class="pagination">

					<?php
						global $wp_query;

						$big = 999999999;
						$translated = __( 'Page', 'oph' );

						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'end_size' => 2,
							'mid_size' => 2,
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $grants->max_num_pages,
							'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
						) );
					?>
				</nav>

				<div class="feed-footer__options">
					<button class="button button--secondary">View all as list</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>