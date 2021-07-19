<?php
	/**
	 * Template Name: Home
	 */

	the_post();

	get_header();

	$about_button = get_field( 'about_button' );
	$about_content = get_field( 'about_content' );
	$about_title = get_field( 'about_title' );

	$highlighted_grants = get_field( 'highlighted_grants' );
	$highlighted_grants_button = get_field( 'highlighted_grants_button' );
	$highlighted_grants_title = get_field( 'highlighted_grants_title' );

	$homepage_research = get_field( 'homepage_research' );
	$homepage_research_button = get_field( 'homepage_research_button' );
	$homepage_research_title = get_field( 'homepage_research_title' );
?>

<?php get_template_part( 'part/hero' ); ?>

<?php if ( $highlighted_grants ) : ?>
	<div id="highlighted-grants">
		<div class="wrap">
			<?php if ( $highlighted_grants_title ) : ?>
				<div class="line-heading">
					<h2>Highlighted Grants</h2>
				</div>
			<?php endif; ?>

			<ul class="list-3-col" id="highlighted-grants-list">
				<?php foreach ( $highlighted_grants as $grant ) : ?>

					<?php
						$grant_post = $grant['grant'][0];

						if ( $grant_post ) {
							$grants_funding_type = get_the_terms( $grant_post->ID, 'grants-funding-type' );

							$grant_image = get_field( 'category_image', 'grants-funding-type_' . $grants_funding_type[0]->term_id )['sizes']['lg'];

							$grant_link = get_permalink( $grant_post->ID );
							$grant_title = get_the_title( $grant_post->ID );

							$grant_excerpt_source = get_the_excerpt( $grant_post->ID );

							$grant_excerpt = array(
								'append' => '...',
								'limit' => 28,
								'limitby' => 'word',
								'source' => $grant_excerpt_source
							);

							$grant_description = excerpt( $grant_excerpt );
						}

						if ( $grant['description'] ) {
							$grant_description = $grant['description'];
						}

						if ( $grant['image'] ) {
							$grant_image = $grant['image']['sizes']['lg'];
						}

						if ( $grant['link'] ) {
							$grant_link = $grant['link']['url'];
						}

						if ( $grant['title'] ) {
							$grant_title = $grant['title'];
						}
					?>

					<?php if ( $grant_title ) : ?>
						<li>
							<div class="bucket-image">
								<?php if ( $grant_image ) : ?>
									<a href="<?php echo $grant_link; ?>">
										<img src="<?php echo $grant_image; ?>" alt="">
									</a>
								<?php endif; ?>
							</div>

							<h4>
								<a href="<?php echo $grant_link; ?>"><?php echo $grant_title; ?></a>
							</h4>

							<div class="bucket-description">
								<?php echo $grant_description; ?>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>

			<?php if ( $highlighted_grants_button ) : ?>
				<div class="button-group">
					<?php foreach ( $highlighted_grants_button as $i ) : ?>
						<?php if ( $i['link']['url'] ) : ?>
							<a class="button" href="<?php echo $i['link']['url']; ?>"<?php if ( $i['link']['target'] == '_blank' ) { echo ' target="_blank"'; } ?>><?php echo $i['link']['title']; ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<div id="about">
	<div class="wrap">
		<?php if ( $about_title ) : ?>
			<div class="line-heading">
				<h2><?php echo $about_title; ?></h2>
			</div>
		<?php endif; ?>

		<div class="about-content">
			<?php if ( $about_content ) : ?>
				<?php echo $about_content; ?>
			<?php endif; ?>

			<?php if ( $about_button ) : ?>
				<div class="button-group">
					<?php foreach ( $about_button as $i ) : ?>
						<?php if ( $i['link']['url'] ) : ?>
							<a class="button" href="<?php echo $i['link']['url']; ?>"<?php if ( $i['link']['target'] == '_blank' ) { echo ' target="_blank"'; } ?>><?php echo $i['link']['title']; ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php if ( $homepage_research ) : ?>
	<div id="research-updates-preview">
		<div class="wrap">
			<?php if ( $homepage_research_title ) : ?>
				<div class="line-heading">
					<h2><?php echo $homepage_research_title; ?></h2>
				</div>
			<?php endif; ?>

			<div class="research-updates-preview-content">
				<ul class="list-related-posts list-3-col" id="research-updates-preview-list">
					<?php foreach ( $homepage_research as $i ) : ?>

						<?php
							$research_post = $i['post'][0];

							if ( $research_post ) {
								$research_focus_area = get_the_terms( $research_post->ID, 'research-updates-focus-area' );

								$research_link = get_permalink( $research_post->ID );
								$research_title = get_the_title( $research_post->ID );

								$research_excerpt_source = get_the_excerpt( $research_post->ID );

								$research_excerpt = array(
									'append' => '...',
									'limit' => 38,
									'limitby' => 'word',
									'source' => $research_excerpt_source
								);

								$research_description = excerpt( $research_excerpt );
							}

							if ( $research_focus_area ) {
								$research_eyebrow_copy = $research_focus_area[0]->name;

								$research_eyebrow_link = '/research-updates?focus-area=' . $research_focus_area[0]->slug;
							}

							if ( $i['description'] ) {
								$research_description = $i['description'];
							}

							if ( $i['eyebrow_copy'] ) {
								$research_eyebrow_copy = $i['eyebrow_copy'];
							}

							if ( $i['eyebrow_link'] ) {
								$research_eyebrow_copy = $i['eyebrow_link'];
							}

							if ( $i['image'] ) {
								$research_image = $i['image']['sizes']['lg'];
							}

							if ( $i['link'] ) {
								$research_link = $i['link']['url'];
							}

							if ( $i['title'] ) {
								$research_title = $i['title'];
							}
						?>

						<li>
							<?php if ( $research_eyebrow_copy ) : ?>
								<h5><?php if ( $research_eyebrow_link ) { echo '<a href="' . $research_eyebrow_link . '">'; } echo $research_eyebrow_copy; if ( $research_eyebrow_link ) { echo '</a>'; } ?></h5>
							<?php endif; ?>

							<h4>
								<a href="<?php echo $research_link; ?>"><?php echo $research_title; ?></a>
							</h4>

							<?php if ( $research_description ) : ?>
								<div class="single-related-posts__description">
									<?php echo $research_description; ?>
								</div>
							<?php endif; ?>

							<div class="single-related-posts__link">
								<a href="#">
									Read More <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="button-group">
					<a class="button" href="/research-updates">View All Research &amp; Updates</a>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>