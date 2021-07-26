<?php
	/**
	 * Template Name: Research Category
	 */

	the_post();

	get_header();

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	$params = get_url_params();

	$content_type = get_field( 'content_type' );

	$content_type_slug = '';
	$content_type_taxonomy = '';

	if ( $content_type && $content_type->slug ) {
		$content_type_slug = $content_type->slug;
		$content_type_taxonomy = $content_type->taxonomy;
	}

	$date_query = array(
		'relation' => 'or'
	);

	$tax_query = array();

	foreach ( $params as $key => $param ) {
		if ( $key == 'yr' ) {
			foreach ( $param as $value ) {
				$param_date_query = array(
					'year' => $value
				);

				array_push( $date_query, $param_date_query );
			}
		}
	}

	$research = new WP_Query( array(
		'post_type' => 'research',
		'posts_per_page' => 9,
		'order' => 'desc',
		'orderby' => 'date',
		'paged' => $paged,
		'date_query' => $date_query,
		'tax_query' => array(
			array(
				'taxonomy' => $content_type_taxonomy,
				'field' => 'slug',
				'terms' => $content_type_slug
			)
		)
	) );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<?php get_template_part( 'part/page', 'header-categories' ); ?>

<div class="feed-section is-feed-category-template">
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
							<a href="#a-z">A to Z</a>
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
								<a href="#a-z">A to Z</a>
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
			<?php if ( $research->have_posts() ) : ?>
				<div class="block-feed">
					<?php while ( $research->have_posts() ) : $research->the_post(); ?>

						<?php
							$post_content_type = get_the_terms( $post->ID, 'content-type' );
							$post_focus_area = get_the_terms( $post->ID, 'focus-area' );
						?>

						<div class="block-feed-post">
							<h4>
								<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
							</h4>

							<h5>
								<?php echo get_the_date( 'F j, Y', $research->ID ); ?>
							</h5>

							<?php if ( $post_focus_area ) : ?>
								<h5>
									<a href="?focus-area=<?php echo $post_focus_area[0]->slug; ?>#categories"><?php echo $post_focus_area[0]->name; ?></a>
								</h5>
							<?php endif; ?>

							<div class="block-feed-post__link">
								<a href="<?php echo the_permalink(); ?>">
									Learn more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
								</a>
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
							'total' => $research->max_num_pages,
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