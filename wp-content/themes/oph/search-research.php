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
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'a-z' ) ); ?>">A to Z</a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'recent' ) ); ?>">Newest to oldest</a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'oldest-to-newest' ) ); ?>">Oldest to newest</a>
						</li>
					</ul>
				</div>

				<div class="dropdown dropdown--inline-content">
					<button class="button" href="#">
						Items <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
					</button>

					<ul class="dropdown-content">
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'items', '25' ) ); ?>">25</a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'items', '50' ) ); ?>">50</a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'items', '100' ) ); ?>">100</a>
						</li>
					</ul>
				</div>

				<button class="button button--solid button-view-list">
					<?php echo oph_display_type('grid'); ?>
				</button>
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
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'a-z' ) ); ?>">A to Z</a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'recent' ) ); ?>">Newest to oldest</a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'oldest-to-newest' ) ); ?>">Oldest to newest</a>
							</li>
						</ul>
					</div>

					<div class="dropdown dropdown--inline-content">
						<button class="button" href="#">
							Items <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
						</button>

						<ul class="dropdown-content">
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'items', '25' ) ); ?>">25</a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'items', '50' ) ); ?>">50</a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'items', '100' ) ); ?>">100</a>
							</li>
						</ul>
					</div>

					<button class="button button--solid button-view-list">
						<?php echo oph_display_type('grid'); ?>
					</button>
				</nav>
			</div>
		</div>

		<div class="feed-section__posts wrap">
			<?php if ( have_posts() ) : ?>
				<div class="block-feed">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							$post_content_type = get_the_terms( $post->ID, 'content-type' );
							$post_focus_area = get_the_terms( $post->ID, 'focus-area' );
						?>

						<div class="block-feed-post">
							<h4>
								<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
							</h4>

							<h5>
								<?php echo get_the_date( 'F j, Y' ); ?>
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
				<div class="feed-footer__options">
					<button class="button button--secondary button-view-list">
						<?php echo oph_display_type('grid'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>