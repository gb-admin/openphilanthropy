<?php
	get_header();

	get_template_part( 'part/page-header', 'search' );
?>

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

				<button class="button button--solid button-view-list">View as List</button>
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

					<button class="button button--solid button-view-list">View as List</button>
				</nav>
			</div>
		</div>

		<div class="feed-section__posts wrap">
			<?php if ( have_posts() ) : ?>
				<div class="block-feed block-feed--images">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							$grant_amount = get_field( 'grant_amount' );

							$focus_area = get_the_terms( $post->ID, 'focus-area' );
							$organization_name = get_the_terms( $post->ID, 'organization-name' );
							$post_thumbnail = get_the_post_thumbnail_url( $post->ID, 'lg' );

							if ( ! $post_thumbnail && ! is_wp_error( $focus_area ) ) {
								$post_thumbnail = get_field( 'category_image', 'focus-area_' . $focus_area[0]->term_id )['sizes']['lg'];
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
								<h6>Grant Title</h6>

								<h4 class="block-feed-post__title">
									<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
								</h4>

								<h6>Organization Name</h6>

								<?php if ( $organization_name && ! is_wp_error( $organization_name ) ) : ?>
									<h4 class="block-feed-post__organization-name"><a href="?organization-name=<?php echo $focus_area[0]->slug; ?>#categories"><?php echo $organization_name[0]->name; ?></a></h4>
								<?php else : ?>
									<div aria-hidden="true" class="block-feed-post__organization-name"></div>
								<?php endif; ?>

								<h6>Focus Area</h6>

								<?php if ( $focus_area && ! is_wp_error( $focus_area ) ) : ?>
									<h5 class="block-feed-post__focus-area">
										<a href="?focus-area=<?php echo $focus_area[0]->slug; ?>#categories"><?php echo $focus_area[0]->name; ?></a>
									</h5>
								<?php endif; ?>

								<h6>Amount</h6>

								<?php if ( $grant_amount ) : ?>
									<h5><?php echo '$' . number_format( $grant_amount ); ?></h5>
								<?php endif; ?>

								<h6>Date</h6>

								<h5 class="block-feed-post__date">
									<?php echo get_the_date( 'F j, Y', $grants->ID ); ?>
								</h5>

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
				<div class="feed-footer__options">
					<button class="button button--secondary">View as List</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>