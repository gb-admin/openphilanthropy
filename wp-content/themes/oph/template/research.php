<?php

/**
 * Template Name: Research
 */

the_post();

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$params = get_url_params();

$view_list = true; // this is the default view

if (isset($params['view-list'][0]) && $params['view-list'][0] == 'false') {
	$view_list = false;
}

$featured_research = get_field('featured_research');

$featured_research_id = [];

if ($featured_research) {
        array_push($featured_research_id, $featured_research->ID);
}

$amount_meta_query = array(
	'relation' => 'or'
);

$date_query = array(
	'relation' => 'or'
);

$order_query = 'desc';

$tax_query = array(
	'relation' => 'and'
);
$content_query = array(
	'relation' => 'or'
);
$focus_query = array(
	'relation' => 'or'
);

$orderby_query = 'date';
$meta_key = '';
$param_amount_meta_query = '';
$posts_per_page = 9;
$taxonomy = '';

foreach ($params as $key => $param) {
	if ($key == 'items') {
		foreach ($param as $value) {
			if ($value == '25') {
				$posts_per_page = 25;
			} elseif ($value == '50') {
				$posts_per_page = 50;
			} elseif ($value == '100') {
				$posts_per_page = 100;
			}
		}
	} elseif ($key == 'sort') {
		foreach ($param as $value) {
			if ($value == 'a-z') {
				$order_query = 'asc';
				$orderby_query = 'title';
			} elseif ($value == 'recent') {
				$order_query = 'desc';
				$orderby_query = 'date';
			} elseif ($value == 'oldest-to-newest') {
				$order_query = 'asc';
				$orderby_query = 'date';
			}
		}
	} elseif (str_contains($key, 'yr')) {
		foreach ($param as $value) {
			$param_date_query = array(
				'year' => $value
			);

			array_push($date_query, $param_date_query);
		}
	} elseif (str_contains($key, 'focus-area')) {
		$key = 'focus-area';
		$taxonomy = get_taxonomy($key);
	} elseif (str_contains($key, 'content-type')) {
		$key = 'content-type';
		$taxonomy = get_taxonomy($key);
	} else {
		$taxonomy = get_taxonomy($key);
	}

	if ($taxonomy) {
		foreach ($param as $value) {
			if (term_exists($value, $taxonomy->name)) {
				$param_query = array(
					'taxonomy' => $taxonomy->name,
					'terms' => $value,
					'field' => 'slug'
				);

				switch ($taxonomy->name) {
					case 'focus-area':
						array_push($focus_query, $param_query);
						break;
					case 'content-type':
						array_push($content_query, $param_query);
						break;
				}
			}
		}
	}
}

array_push($tax_query, $focus_query);
array_push($tax_query, $content_query);

// print_r($tax_query);

$args = array(
	'post_type' => 'research',
	'posts_per_page' => $posts_per_page,
	'order' => $order_query,
	'orderby' => $orderby_query,
	'paged' => $paged,
	'post__not_in' => $featured_research_id,
	'date_query' => $date_query,
	'meta_query' => $amount_meta_query,
	'tax_query' => $tax_query,
	'meta_key' => $meta_key
);

foreach ($params as $key => $param) :
	if (str_contains($key, 'author')) {
		$args['meta_query'][] = array(
			'key'     => 'custom_author',
			'value'   => $param,
			'compare' => 'IN'
		);
	}
endforeach;

if (isset($params['q'][0])) {
	$args['s'] = $params['q'][0];
}

$research = new WP_Query($args);
?>

<?php get_template_part('part/page', 'header'); ?>

<?php get_template_part('part/page', 'header-categories'); ?>

<div class="feed-section">
	<?php get_template_part('part/feed', 'options', array('post_type' => 'research')); ?>

	<div class="feed-section__content">
		<?php get_template_part('part/filter', 'sidebar', array('post_type' => 'research')); ?>

		<?php get_template_part('part/feed', 'options-mobile'); ?>

		<div class="feed-section__posts wrap">
			<ul class="block-feed-title-head is-research<?php if ($view_list) {
															echo ' is-active';
														} ?>">
				<li>
					<h6 class="feed-sorter" data-sort="title">Title</h6>
				</li>
				<li>
					<h6 class="feed-sorter" data-sort="date">Date</h6>
				</li>
				<li>
					<h6 class="feed-sorter" data-sort="focus">Focus Area</h6>
				</li>
				<li>
					<h6 class="feed-sorter" data-sort="content">Content Type</h6>
				</li>
			</ul>

			<?php if ($research->have_posts()) : ?>
				<div class="block-feed block-feed--research<?php if ($view_list) {
																echo ' block-feed--list';
															} ?>">
					<div class="block-feed-post--container">
						<?php while ($research->have_posts()) : $research->the_post(); ?>

							<?php
							$research_content_type = get_the_terms($post->ID, 'content-type');
							$research_focus_area = get_the_terms($post->ID, 'focus-area');
							// setting data-terms for live sorting 
							$sortTitle = strtok(get_the_title($post->ID), " ");
							$sortDate = get_the_date('Y-m-d', $research->ID);
							$sortFocus = '';
							if ($research_focus_area) {
								$primary_term = get_post_meta($post->ID, '_yoast_wpseo_primary_focus-area', true);
							        $focus_area = get_the_terms( $post->ID, 'focus-area' );
                                                                $primary_term = 0;
                                                                $primary_term = get_post_meta($post->ID, '_yoast_wpseo_primary_focus-area', true);
                                                                // Make sure $primary_focus_area is not empty.
                                                                $primay_focus_area = new stdClass();

                                                                $focus_only = array();
                                                                foreach( $focus_area as $area ){
                                                                        $focus_only[] = $area;
                                                                }
                                                                $primary_focus_area = $focus_only[0];

                                                                foreach ( $focus_only as $focus ) {
                                                                        if ( $primary_term == $focus->term_id) {
                                                                                $primary_focus_area = $focus;
                                                                        }
                                                                }

								$sortFocus = $primary_focus_area->name;
							}

							$sortContent = '';
							if ($research_content_type) {
								$sortContent = $research_content_type[0]->name;
							}
							$linkExternally = get_field('externally_link');
							$externalURL = get_field('external_url');
							$hidePub = get_field('hide_pubDate');
							?>

							<div class="block-feed-post same-height block-feed-post-research" data-sort-title="<?php echo $sortTitle; ?>" <?php if (!$hidePub) {
																																				echo 'data-sort-date="' . $sortDate . '"';
																																			} else {
																																				echo 'data-sort-date=""';
																																			} ?> data-sort-focus="<?php echo $sortFocus; ?>" data-sort-content="<?php echo $sortContent; ?>">
								<div class="block-feed-post__eyebrow">
									<p>
										<?php if (!$hidePub) {
											echo get_the_date('F Y', $research->ID);
										} ?>
									</p>
								</div>
								<div class="block-feed-post__body">
									<h6>Title</h6>

									<h4 class="block-feed-post__title">
										<?php if ($linkExternally) { ?>
											<a href="<?php echo $externalURL; ?>"><?php the_title(); ?></a>
										<?php } else { ?>
											<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
										<?php } ?>
									</h4>

									<h6>Date</h6>

									<h5 class="block-feed-post__date">
										<?php if (!$hidePub) {
											echo get_the_date('F d, Y', $research->ID);
										} ?>
									</h5>

									<h6>Focus Area</h6>

									<h5 class="block-feed-post__category">
										<?php if ($research_focus_area) : ?>
											<a href="?focus-area=<?php echo $primary_focus_area->slug; ?>#categories"><?php echo $primary_focus_area->name; ?></a>
										<?php endif; ?>
									</h5>

									<h6>Content Type</h6>
									<h5 class='block-feed-post__content_type'>
										<?php if ($research_content_type) : ?>
											<ul class="research-content-type">
												<?php foreach ($research_content_type as $term) :
													$slug = $term->slug;
													$url = esc_url(add_query_arg('content-type', $slug)); ?>

													<li><a href="<?= $url ?>"><?php _e($term->name); ?></a></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</h5>

								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					</div>
					<div class="feed-footer">
						<nav aria-label="Post Feed Pagination" class="pagination">

							<?php
							global $wp_query;

							$big = 999999999;
							$translated = __('Page', 'oph');

							$base_url = add_query_arg(array(
								'view-list' => $view_list ? "true" : "false"
							), str_replace("#038;", "&", esc_url(get_pagenum_link($big))));

							echo paginate_links(array(
								'base' => str_replace($big, '%#%', $base_url),
								'end_size' => 2,
								'mid_size' => 2,
								'format' => '?paged=%#%',
								'current' => max(1, get_query_var('paged')),
								'total' => $research->max_num_pages,
								'before_page_number' => '<span class="screen-reader-text">' . $translated . ' </span>'
							));
							?>
						</nav>

						<div class="feed-footer__options">
							<button class="button button--secondary button-view-list">
								<?php echo oph_display_type('list'); ?>
							</button>
						</div>
					</div>
				</div>
		</div>
	<?php else : ?>
		<h3 style="padding: 36px 0; text-align: center;">No posts found matching criteria.</h3>
	<?php endif; ?>
	</div>
</div>

<?php get_template_part('part/cta', 'button'); ?>

<?php get_footer(); ?>
