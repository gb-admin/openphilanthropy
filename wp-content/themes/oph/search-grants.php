<?php
	get_header();

	get_template_part( 'part/page-header', 'search' );

	$sort_params = [
		'high-to-low'      => 'High to lowest',
		'a-z'              => 'A - Z',
		'recent'           => 'Newest to oldest',
		'oldest-to-newest' => 'Oldest to newest'
	];
?>

<div class="feed-section is-feed-category-template">
	<div class="feed-options-bar">
		<div class="wrap">
			<nav aria-label="Feed Options Bar">
				<div class="dropdown">
					<button class="button" href="#">
						Sort <?php if ( isset($_GET['sort']) ) echo "({$sort_params[$_GET['sort']]}) &nbsp;"; ?>
						<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
					</button>

					<ul class="dropdown-content">
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'high-to-low' ) ); ?>"><?= $sort_params['high-to-low']; ?></a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'a-z' ) ); ?>"><?= $sort_params['a-z']; ?></a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'recent' ) ); ?>"><?= $sort_params['recent']; ?></a>
						</li>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'oldest-to-newest' ) ); ?>"><?= $sort_params['oldest-to-newest']; ?></a>
						</li>
					</ul>
				</div>

				<div class="dropdown dropdown--inline-content">
					<button class="button" href="#">
						Items  <?php if ( isset($_GET['items']) ) echo "({$_GET['items']})"; ?>
						<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
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
			</nav>
		</div>
	</div>

	<div class="feed-section__content">
		<div class="feed-options-bar feed-options-bar--mobile">
			<div class="wrap">
				<nav aria-label="Feed Options Bar">
					<div class="dropdown">
						<button class="button" href="#">
							Sort <?php if ( isset($_GET['sort']) ) echo "({$sort_params[$_GET['sort']]}) &nbsp;"; ?>
							<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
						</button>

						<ul class="dropdown-content">
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'high-to-low' ) ); ?>"><?= $sort_params['high-to-low']; ?></a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'a-z' ) ); ?>"><?= $sort_params['a-z']; ?></a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'recent' ) ); ?>"><?= $sort_params['recent']; ?></a>
							</li>
							<li>
								<a href="<?php echo esc_url( add_query_arg( 'sort', 'oldest-to-newest' ) ); ?>"><?= $sort_params['oldest-to-newest']; ?></a>
							</li>
						</ul>
					</div>

					<div class="dropdown dropdown--inline-content">
						<button class="button" href="#">
							Items <?php if ( isset($_GET['items']) ) echo "({$_GET['items']})"; ?>
							<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
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
				</nav>
			</div>
		</div>

		<div class="feed-section__posts wrap">
			<?php if ( have_posts() ) : ?>
				<div class="block-feed block-feed--images">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							$grant_amount = get_field( 'grant_amount' );

							$organization_name = get_the_terms( $post->ID, 'organization-name' );
							$post_thumbnail = get_the_post_thumbnail_url( $post->ID, 'lg' );

							$focus_area = get_the_terms( $post->ID, 'focus-area' );
							$focus_area_num = sizeof($focus_area);
							$primary_term = get_post_meta($post->ID, '_yoast_wpseo_primary_focus-area', true);

							$focus_only = array(); 
							foreach( $focus_area as $area ){ 
								$ancestors = get_ancestors($area->term_id, 'focus-area', 'taxonomy'); 
								$depth = count($ancestors);	
								if ( $depth == 1 ) { 
									$focus_only[] = $area; 
								} elseif ( $depth == 0 ) {
									$post_category = $area; 
								}
							} 

							$post_focus = count($focus_only); 								
							if ( $post_focus == 1 ) { 
								$primary_focus_area = $focus_only[0]; 
							} elseif ( $post_focus > 1 ) { 
								foreach ( $focus_only as $focus ) { 
									if ( $primary_term == $focus->term_id ) {
										$primary_focus_area = $focus; 
									} 
								} 
							} else { 
								$primary_focus_area = $post_category; 
							} 

							if ( ! $post_thumbnail && ! is_wp_error( $focus_area ) ) {
								$post_thumbnail = get_field( 'category_image', 'focus-area_' . $primary_focus_area )['sizes']['lg'];
							}
						?>

						<div class="block-feed-post<?php if ( ! $post_thumbnail ) { echo ' no-thumbnail'; } ?>">
							<?php 
							$award_date = get_field( 'award_date' );
							if ( $award_date ) : ?>
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
									<h4 class="block-feed-post__organization-name"><a href="?organization-name=<?php echo $focus_area[0]->slug; ?>#categories"><?php echo $organization_name[0]->name; ?></a></h4>
								<?php else : ?>
									<div aria-hidden="true" class="block-feed-post__organization-name"></div>
								<?php endif; ?>

								<h6>Focus Area</h6>

								<?php if ( $primary_focus_area && ! is_wp_error( $primary_focus_area ) ) : ?>
									<h5 class="block-feed-post__focus-area">
										<a href="/grants?focus-area=<?php echo $primary_focus_area->slug; ?>#categories"><?php echo $primary_focus_area->name; ?></a>
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
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>