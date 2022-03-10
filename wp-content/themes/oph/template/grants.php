<?php
	/**
	 * Template Name: Grants
	 */

	the_post();

	get_header();

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	$params = get_url_params();

	$view_list = false;

	if ( isset( $params['view-list'][0] ) && $params['view-list'][0] == 'true' ) {
		$view_list = true;
	}

	$featured_grants = get_field( 'featured_grants' );

	$featured_grants_id = [];

	if ( $featured_grants ) {
		array_push( $featured_grants_id, $featured_grants->ID );
	}

	$amount_meta_query = array(
		'relation' => 'or'
	);

	$date_meta_query = array(
		'relation' => 'or'
	);

	$meta_query = array(
		'relation' => 'and',
		'order_clause' => array(
            'key' => 'award_date',
            'type' => 'date'
		)
	);

	$order_query = 'desc';

	$tax_query = array(
		'relation' => 'or'
	);

	$orderby_query = 'meta_value';
	$meta_key = 'award_date';
	$param_amount_meta_query = '';
	$posts_per_page = 25;
	$taxonomy = '';

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

				if ( $param_amount_meta_query ) {
					array_push( $amount_meta_query, $param_amount_meta_query );
				}
			}
		} elseif ( $key == 'items' ) {
			foreach ( $param as $value ) {
				if ( $value == '25' ) {
					$posts_per_page = 25;
				} elseif ( $value == '50' ) {
					$posts_per_page = 50;
				} elseif ( $value == '100' ) {
					$posts_per_page = 100;
				}
			}
		} elseif ( $key == 'sort' ) {
			foreach ( $param as $value ) {
				if ( $value == 'a-z' ) {
					$order_query = 'asc';
					$orderby_query = 'title';
				} elseif ( $value == 'high-to-low' ) {
					$meta_key = 'grant_amount';
					$orderby_query = 'meta_value_num';
				} elseif ( $value == 'recent' ) {
					$meta_key = 'award_date';
					$order_query = 'desc';
					$orderby_query = 'meta_value';
				} elseif ( $value == 'oldest-to-newest' ) {
					$meta_key = 'award_date';
					$order_query = 'asc';
					$orderby_query = 'meta_value';
				}
			}
		} elseif ( $key == 'yr' ) {
			foreach ( $param as $value ) {
				$param_date_query = array(
					'key' => 'award_date',
					'value' =>  array( $value . '-01-01', $value . '-12-31' ),
					'type' => 'date',
					'compare' => 'between'
				);

				array_push( $date_meta_query, $param_date_query );
			}
		} else {

			// Get taxonomy by $key
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

	array_push( $meta_query, $amount_meta_query );
	array_push( $meta_query, $date_meta_query );

	$grants = new WP_Query( array(
		'post_type' => 'grants',
		'posts_per_page' => $posts_per_page,
		'order' => $order_query,
		'orderby' => $orderby_query,
		'paged' => $paged,
		'post__not_in' => $featured_grants_id,
		'meta_query' => $meta_query,
		'tax_query' => $tax_query,
		'meta_key' => $meta_key
	) );

	$grants_posts = $grants->posts;
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<?php get_template_part( 'part/page', 'header-categories' ); ?>

<div class="feed-section">
	<?php get_template_part( 'part/feed', 'options' ); ?>

	<div class="feed-section__content">
		<?php get_template_part( 'part/filter', 'sidebar', array( 'post_type' => 'grants', 'grants_query' => $grants ) ); ?>

		<?php get_template_part( 'part/feed', 'options-mobile' ); ?>

		<div class="feed-section__posts wrap">
			<ul class="block-feed-title-head<?php if ( $view_list ) { echo ' is-active'; } ?>">
				<li>
					<h6>Grant<br> Title</h6>
				</li>
				<li>
					<h6>Organization<br> Name</h6>
				</li>
				<li>
					<h6>Focus<br> Area</h6>
				</li>
				<li>
					<h6>Amount</h6>
				</li>
				<li>
					<h6>Date</h6>
				</li>
			</ul>

			<?php if ( $grants->have_posts() ) : ?>
				<div class="block-feed block-feed--images<?php if ( $view_list ) { echo ' block-feed--list'; } ?>"> 
					<div class="block-feed-post--container">
						<?php while ( $grants->have_posts() ) : $grants->the_post(); ?>

							<?php
								$award_date = get_field( 'award_date' );
								$grant_amount = get_field( 'grant_amount' );

								$organization_name = get_the_terms( $post->ID, 'organization-name' );
								$post_thumbnail = get_the_post_thumbnail_url( $post->ID, 'lg' );
								
								$focus_area = get_the_terms( $post->ID, 'focus-area' );
								$primary_term = get_post_meta($post->ID, '_yoast_wpseo_primary_focus-area', true);

								foreach( $focus_area as $term ){
									//Set primary term. Primary should not show GHW, LT, or OA as primary, even if set in backend.
									if( $primary_term == $term->term_id && !( $term->slug == 'global-health-wellbeing' || $term->slug == 'longtermism' || $term->slug == 'other-areas' ) ){
										$primary_focus_area = $term;
									}
								}
								//Check if term is not set. Useful for when only one area for post is set as GHW, LT, or OA
								if( !$primary_focus_area ){ $primary_focus_area = $focus_area[0]; }

								if ( ! $post_thumbnail && ! is_wp_error( $primary_focus_area ) ) {
									$post_thumbnail = get_field( 'category_tile_image', 'focus-area_' . $primary_focus_area->term_id )['sizes']['lg'];
								}

								if ( ! $post_thumbnail ) {
									$post_thumbnail = get_field( 'category_image', 'focus-area_' . $primary_focus_area->term_id )['sizes']['lg'];
								}
							?>

							<div class="block-feed-post<?php if ( ! $post_thumbnail ) { echo ' no-thumbnail'; } if ( ! $award_date ) { echo ' no-award-date'; } ?>">
								<?php if ( $award_date ) : ?>
									<h5 class="block-feed-post__date">
										<?php echo date("F Y", strtotime($award_date)); ?>
									</h5>
								<?php endif; ?>

								<div class="block-feed-post__head">
									<?php if ( $post_thumbnail ) : ?>
										<a href="<?php echo the_permalink(); ?>">
											<img src="<?php echo $post_thumbnail; ?>" alt="">
										</a>
									<?php endif; ?>
								</div>

								<div class="block-feed-post__body">
									<h6>Grant Title</h6>

									<h4 class="block-feed-post__title">
										<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
									</h4>

									<h6>Organization Name</h6>

									<?php if ( $organization_name && ! is_wp_error( $organization_name ) ) : ?>
										<h4 class="block-feed-post__organization-name"><a href="?organization-name=<?php echo $organization_name[0]->slug; ?>#categories"><?php echo $organization_name[0]->name; ?></a></h4>
									<?php else : ?>
										<div aria-hidden="true" class="block-feed-post__organization-name"></div>
									<?php endif; ?>

									<h6>Focus Area</h6>

									<h5 class="block-feed-post__focus-area">
										<?php if ( $primary_focus_area && ! is_wp_error( $primary_focus_area ) ) : ?>
											<?php
												$name = $primary_focus_area->name;
												$slug = $primary_focus_area->slug; 
												$url = esc_url( add_query_arg( 'focus-area', $slug ) ); ?>

												<a href="<?= $url ?>" class="focus-area-link"><?= $name ?></a>
										<?php endif; ?>
									</h5>

									<h6>Amount</h6>

									<?php if ( $grant_amount ) : ?>
										<h5 class='block-feed-post__grant-amount'><?php echo '$' . number_format( $grant_amount ); ?></h5>
									<?php endif; ?>

									<h6>Date</h6>

									<h5 class="block-feed-post__date"><?php echo date("F Y", strtotime($award_date)); ?></h5>

									<div class="block-feed-post__link">
										<a href="<?php echo the_permalink(); ?>">
											Learn more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
										</a>
									</div>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
					<div class="feed-footer">
						<nav aria-label="Post Feed Pagination" class="pagination">

							<?php
								global $wp_query;

								$big = 999999999;
								$translated = __( 'Page', 'oph' );

								// Setting the view-list parameter on pagination url.
								// Note the ampersand is replaced prior to running the method as it causes unexpected behaviour
								$base_url = add_query_arg( array(
									'view-list' => $view_list ? "true" : "false"
								), str_replace("#038;", "&", esc_url( get_pagenum_link( $big )) ) );

								echo paginate_links( array(
									'base' => str_replace( $big, '%#%', $base_url ),
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
						</div>
					</div>
				</div>
			<?php else : ?>
				<h3 style="padding: 36px 0; text-align: center;">No posts found matching criteria.</h3>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta', 'button' ); ?>

<?php get_footer(); ?>