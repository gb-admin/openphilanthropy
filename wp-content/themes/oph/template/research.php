<?php
	/**
	 * Template Name: Research
	 */

	the_post();

	get_header();

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	$params = get_url_params();

	$view_list = false;

	if ( isset( $params['view-list'][0] ) && $params['view-list'][0] == 'true' ) {
		$view_list = true;
	}

	$featured_research_updates = get_field( 'featured_research_updates' );

	$featured_research_updates_id = [];

	if ( $featured_research_updates ) {
		array_push( $featured_research_updates_id, $featured_research_updates->ID );
	}

	$date_query = array(
		'relation' => 'or'
	);

	$meta_query = array(
		'relation' => 'and'
	);

	$order_query = 'desc';

	$tax_query = array(
		'relation' => 'or'
	);

	$orderby_query = 'date';
	$meta_key = '';
	$param_amount_meta_query = '';
	$posts_per_page = 9;
	$taxonomy = '';

	foreach ( $params as $key => $param ) {
		if ( $key == 'items' ) {
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
					$order_query = 'desc';
					$orderby_query = 'date';
				}
			}
		} elseif ( $key == 'yr' ) {
			foreach ( $param as $value ) {
				$param_date_query = array(
					'year' => $value
				);

				array_push( $date_query, $param_date_query );
			}
		} else {
			$taxonomy = get_taxonomy( $key );
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

	$research = new WP_Query( array(
		'post_type' => 'research',
		'posts_per_page' => $posts_per_page,
		'order' => $order_query,
		'orderby' => $orderby_query,
		'paged' => $paged,
		'post__not_in' => $featured_research_updates_id,
		'date_query' => $date_query,
		'tax_query' => $tax_query
	) );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<?php get_template_part( 'part/page', 'header-categories' ); ?>

<div class="feed-section">
	<?php get_template_part( 'part/feed', 'options' ); ?>

	<div class="feed-section__content">
		<?php get_template_part( 'part/filter', 'sidebar' ); ?>

		<?php get_template_part( 'part/feed', 'options-mobile' ); ?>

		<div class="feed-section__posts wrap">
			<?php if ( $research->have_posts() ) : ?>
				<div class="block-feed<?php if ( $view_list ) { echo ' block-feed--list'; } ?>">
					<?php while ( $research->have_posts() ) : $research->the_post(); ?>

						<?php
							$research_content_type = get_the_terms( $post->ID, 'content-type' );
							$research_focus_area = get_the_terms( $post->ID, 'focus-area' );
						?>

						<div class="block-feed-post">
							<h4>
								<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
							</h4>

							<h5>
								<?php echo get_the_date( 'F j, Y', $research->ID ); ?>
							</h5>

							<?php if ( $research_focus_area ) : ?>
								<h5>
									<a href="?focus-area=<?php echo $research_focus_area[0]->slug; ?>#categories"><?php echo $research_focus_area[0]->name; ?></a>
								</h5>
							<?php endif; ?>

							<div class="block-feed-post__link">
								<a href="<?php echo the_permalink(); ?>">
									Learn more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
								</a>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
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

<?php get_template_part( 'part/cta', 'button' ); ?>

<?php get_footer(); ?>