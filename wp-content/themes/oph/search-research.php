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
							Sort <?php if ( isset($_GET['sort']) ) echo "({$sort_params[$_GET['sort']]}) &nbsp;"; ?>
							<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
						</button>

						<ul class="dropdown-content">
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
							if ( $post_focus_area ) {
								$primary_term = get_post_meta($post->ID, '_yoast_wpseo_primary_focus-area', true); 

								$focus_only = array(); 
								foreach( $post_focus_area as $area ){ 
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
							} 

							$linkExternally = get_field('externally_link'); 
							$externalURL = get_field('external_url'); 
						?>

						<div class="block-feed-post">
							<h4>
								<?php if ( $linkExternally ) { ?>
									<a href="<?php echo $externalURL; ?>"><?php the_title(); ?></a>
								<?php } else { ?>
									<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
								<?php } ?>
							</h4>

							<h5>
								<?php echo get_the_date( 'F j, Y' ); ?>
							</h5>

							<?php if ( $post_focus_area ) : ?>
								<h5>
									<a href="/research?focus-area=<?php echo $primary_focus_area->slug; ?>#categories"><?php echo $primary_focus_area->name; ?></a>
								</h5>
							<?php endif; ?>

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
