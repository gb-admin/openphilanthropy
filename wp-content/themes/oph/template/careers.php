<?php
	/**
	 * Template Name: Careers
	 */

	the_post();

	get_header();

	$careers_content = get_field( 'careers_content' );
	$footnotes = get_field( 'footnotes' );

	function get_display_order_post_ids() {
		$career_ids = get_posts([
			'post_type'      => 'careers',
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'desc',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		]);

		// Set general application to always be last
		$general_application_post_id =  get_page_by_path( 'general-application', OBJECT, 'careers' )->ID ?? '';

		if (
				($key = array_search($general_application_post_id, $career_ids)) !== false &&
				$key != count($career_ids) - 1
			) {
			unset($career_ids[$key]);
			$career_ids = array_values($career_ids); // reset index
			array_push($career_ids, $general_application_post_id);
		}
		
		return $career_ids;
	}

	$careers = new WP_Query( array(
		'post_type' => 'careers',
		'posts_per_page' => -1,
		'post__in'	=> get_display_order_post_ids(),
		'orderby' => 'post__in'
	) );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-careers" id="careers">
	<div class="wrap">
		<div class="content-careers__main">
			<div class="content-careers__aside pagenav-aside">
				<h3>Navigate this page with the links below</h3>

				<?php if ( ! empty( $careers_content ) ) : ?>
					<nav aria-label="Post Navigation" class="aside-post-navigation" id="nav-post">
						<ul class="list-aside-post-navigation" id="post-navigation-list">
							<?php foreach ( $careers_content as $content ) : ?>

								<?php
									$pagenav_anchor = strtolower( sanitize_title_with_dashes( $content['title'] ) );
								?>

								<li>
									<a data-goto="#<?php echo $pagenav_anchor; ?>" href="<?php echo $pagenav_anchor; ?>" title="<?php echo $content['title']; ?>">
										<span><?php echo $content['title']; ?></span>

										<svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"></path></svg>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>

					<nav aria-label="Mobile Post Navigation" class="aside-post-navigation-mobile" id="nav-post-mobile">
						<select data-input-placeholder="Type to search..." class="goto-select" id="post-navigation-list-mobile">
							<?php foreach ( $careers_content as $content ) : ?>

								<?php
									$pagenav_anchor = strtolower( sanitize_title_with_dashes( $content['title'] ) );
								?>

								<option value="<?php echo $pagenav_anchor; ?>"><?php echo $content['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</nav>
				<?php endif; ?>

				<svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>

				<div class="post-share">
					<div class="a2a_wrapper">
						<div class="a2a_kit a2a_kit_size_32 a2a_default_style social-media">
							<a class="a2a_button_twitter">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
							</a>

							<a class="a2a_button_facebook">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
							</a>

							<a class="a2a_button_linkedin">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
							</a>
						</div>

						<script async src="https://static.addtoany.com/menu/page.js"></script>
					</div>
				</div>
			</div>

			<div class="content-careers__entry pagenav-content">
				<?php if ( $careers->have_posts() ) : ?>
					<div class="careers-positions">
						<h2>Open Positions</h2>

						<ul class="list-career-positions">
							<?php while ( $careers->have_posts() ) : $careers->the_post(); ?>

								<?php
									$application_link_text = get_field( 'application_link_text' );
									$application_link_url = get_field( 'application_link_url' );

									if ( ! $application_link_text ) {
										$application_link_text = 'Apply here';
									}
								?>

								<?php if ( $application_link_url ) : ?>
									<li>
										<h3><a href="<?php echo $application_link_url['url']; ?>"><?php the_title(); ?></a></h3>

										<p>
											<a class="application-link" href="<?php echo $application_link_url['url']; ?>">
												<?php echo $application_link_text; ?>

												<svg aria-hidden="true" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
											</a>
										</p>
									</li>
								<?php endif; ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php endif; ?>

				<div class="careers-signup-form">
					<h3>Sign up for job alerts</h3>

					<?php echo do_shortcode( '[gravityforms id="1"]' ); ?>
				</div>

				<?php if ( have_rows( 'careers_content' ) ) : ?>
					<div class="flexible-content-careers">
						<?php while ( have_rows( 'careers_content' ) ) : the_row(); ?>

							<?php
								$title = get_sub_field( 'title' );
								$title_id = sanitize_title_with_dashes( $title );
							?>

							<div class="content-careers__section">
								<div class="entry-title">
									<h2 id="<?php echo $title_id; ?>"><?php echo $title; ?></h2>
								</div>

								<?php if ( have_rows( 'flexible_content' ) ) : ?>
									<?php while ( have_rows( 'flexible_content' ) ) : the_row(); ?>
										<?php if ( get_row_layout() == 'content' ) : ?>

											<?php
												$content = get_sub_field( 'content' );
											?>

											<div class="entry-content">
												<?php echo $content; ?>
											</div>
										<?php elseif ( get_row_layout() == 'quote_slideshow' ) : ?>

											<?php
												$quote_slideshow = get_sub_field( 'quote_slideshow' );
											?>

											<?php if ( ! empty( $quote_slideshow ) ) : ?>
												<div class="quote-slideshow">
													<div class="quote-slideshow__body">
														<div class="quote-slideshow__slider<?php if ( count( $quote_slideshow ) > 1 ) { echo ' is-reel'; } ?>">
															<?php foreach ( $quote_slideshow as $slide ) : ?>
																<?php if ( $slide['quote'] ) : ?>
																	<div>
																		<?php if ( $slide['image'] ) : ?>
																			<img src="<?php echo $slide['image']['sizes']['lg']; ?>" alt="">
																		<?php endif; ?>

																		<p>
																			<?php echo $slide['quote']; ?>
																		</p>
																	</div>
																<?php endif; ?>
															<?php endforeach; ?>
														</div>
													</div>

													<div class="quote-slideshow__foot">
														<div class="quote-slideshow__author<?php if ( count( $quote_slideshow ) > 1 ) { echo ' is-reel'; } ?>">
															<?php foreach ( $quote_slideshow as $slide ) : ?>

																<?php
																	$author_image = get_the_post_thumbnail_url( $slide['author']->ID, 'lg' );
																	$author_title = get_the_title( $slide['author']->ID );

																	$team_title = get_field( 'team_title', $slide['author']->ID );
																?>

																<div>
																	<div class="profile-image">
																		<div class="profile-image__avatar">
																			<img src="<?php echo $author_image; ?>" alt="">
																		</div>

																		<div class="profile-image__detail">
																			<h4><?php echo $author_title; ?></h4>

																			<?php if ( $team_title ) : ?>
																				<h6><?php echo $team_title; ?></h6>
																			<?php endif; ?>
																		</div>
																	</div>
																</div>
															<?php endforeach; ?>
														</div>

														<div class="quote-slideshow__nav">
															<button class="slick-arrow" id="quote-slideshow-prev"></button>

															<div class="quote-slideshow-dots"></div>

															<button class="slick-arrow" id="quote-slideshow-next"></button>
														</div>
													</div>
												</div>
											<?php endif; ?>
										<?php elseif ( get_row_layout() == 'text_blocks' ) : ?>

											<?php
												$text_blocks = get_sub_field( 'text_blocks' );
											?>

											<?php if ( ! empty( $text_blocks ) ) : ?>
												<div class="text-blocks">
													<div class="text-blocks__grid">
														<?php foreach ( $text_blocks as $block ) : ?>
															<div class="text-blocks__cell">
																<h4><?php echo $block['title']; ?></h4>

																<?php echo $block['content']; ?>
															</div>
														<?php endforeach; ?>
													</div>
												</div>
											<?php endif; ?>
										<?php endif; ?>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>

				<?php if ( $footnotes ) : ?>
					<div class="content-footnotes">
						<div class="footnotes">
							<?php echo $footnotes; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta-button' ); ?>

<?php get_footer(); ?>