<?php
	$post_type = '';

	if ( isset( $args['post_type'] ) ) {
		$post_type = $args['post_type'];
	}

	$award_date = get_field( 'award_date' );
	$grant_amount = get_field( 'grant_amount' );

	$terms_content_type = get_the_terms( $post->ID, 'content-type' );
	$terms_focus_area = get_the_terms( $post->ID, 'focus-area' );
	$terms_organization_name = get_the_terms( $post->ID, 'organization-name' );

	// ? filter values are duplicated from filter-sidebar
	switch(true) {
		case $grant_amount < 100000:
			$grant_filter = "?amount=less-than-1hundthous#categories";
			break;
		case $grant_amount >= 100000 && $grant_amount <= 1000000 :
			$grant_filter = "?amount=between-1hundthous-1mil#categories";
			break;
		case $grant_amount > 1000000:
			$grant_filter = "?amount=greater-than-1mil#categories";
			break;
		default:
			$grant_filter = "";
			break;
	}
?>

<?php if ( $terms_content_type || $terms_focus_area ) : ?>
	<div class="single-header-categories" id="categories">
		<div class="wrap">
			<div class="single-header-categories__content">
				<nav aria-label="Post Categories List">
					<ul id="single-header-categories-list">
						<?php if ( $terms_focus_area && ! is_wp_error( $terms_focus_area ) ) : ?>
							<?php foreach ( $terms_focus_area as $term ) : ?>
								<?php 
								$ancestors = get_ancestors($term->term_id, 'focus-area', 'taxonomy'); 
								$depth = count($ancestors); 
								?> 
								<li>
									<a href="/<?php echo $post_type; ?>?focus-area=<?php echo $term->slug; ?>">
										<?php 
											if( $depth == 0 ) { echo 'Category: '; } 
											else if ( $depth == 1 ) { echo 'Focus Area: '; }
											else { echo 'Portfolio Area: '; } 
											echo $term->name; ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( $post_type == 'grants' ) : ?>
							<?php if ( $terms_organization_name && ! is_wp_error( $terms_organization_name ) ) : ?>
								<?php foreach ( $terms_organization_name as $term ) : ?>
									<li>
										<a href="/<?php echo $post_type; ?>?organization-name=<?php echo $term->slug; ?>">Organization Name: <?php echo $term->name; ?></a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if ( $grant_amount ) : ?>
								<li>
									<p>Amount: <?php echo '$' . number_format( $grant_amount ); ?></p>
								</li>
							<?php endif; ?>

							<?php if ( $award_date ) : ?>
								<li>
									<p>Award Date: <?php echo date("F Y", strtotime($award_date)); ?></p>
								</li>
							<?php endif; ?>
						<?php elseif ( $post_type == 'research' ) : ?>
							<?php if ( $terms_content_type && ! is_wp_error( $terms_content_type ) ) : ?>
								<?php foreach ( $terms_content_type as $term ) : ?>
									<li>
										<a href="/<?php echo $post_type; ?>?content-type=<?php echo $term->slug; ?>">Content Type: <?php echo $term->name; ?></a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
<?php endif; ?>
