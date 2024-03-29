<?php
	/**
	 * Template Name: Process
	 */

	the_post();

	get_header();

	$footnotes = get_field( 'footnotes' );
	$steps = get_field( 'steps' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-grantmaking-process">
	<div class="wrap">
		<div class="grantmaking-process__main">
			<?php if ( $steps ) : ?>
				<div class="grantmaking-process__aside">
					<h3>Navigate this page with the links below</h3>

					<ul aria-label="Steps Navigation List" class="aside-steps-navigation" id="steps-navigation-list">
						<?php foreach ( $steps as $k => $i ) : ?>

							<?php
								$k = $k + 1;

								$step_href = sanitize_title_with_dashes( $i['title'] );
							?>

							<li>
								<a data-goto="#<?php echo $step_href; ?>" href="#<?php echo $step_href; ?>" title="Stage <?php echo $k; ?>: <?php echo $i['title']; ?>">
									<h6>Stage <?php echo $k; ?>:</h6>

									<h4><?php echo $i['title']; ?> <svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg></h4>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>

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
			<?php endif; ?>

			<?php if ( $steps ) : ?>
				<div class="grantmaking-process__entry">
					<ul class="list-steps" id="grantmaking-process-list">
						<?php foreach ( $steps as $k => $i ) : ?>
							<?php if ( $i['title'] ) : ?>

								<?php
									$k = $k + 1;

									$step_href = sanitize_title_with_dashes( $i['title'] );
								?>

								<li>
									<div class="list-steps__title">
										<div class="list-steps__count">
											<h6>Stage <span class="list-steps__number"><?php echo $k; ?></span></h6>
										</div>

										<h2 id="<?php echo $step_href; ?>"><?php echo $i['title']; ?></h2>
									</div>

									<?php if ( $i['content'] ) : ?>
										<div class="entry-content">
											<?php echo $i['content']; ?>
										</div>
									<?php endif; ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>

					<?php if ( $footnotes ) : ?>
						<div class="content-footnotes">
							<a href='javascript:void(0);' id='toggle-footnotes'
							>
								<span class='expand'>
									Expand Footnotes 
									<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M18.1123 9.71249L12.4996 15.2875L6.8877 9.71249" stroke="#445277" stroke-width="1.49661"/></svg>
								</span>
								<span class='collapse'>
									Collapse Footnotes <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M6.8877 15.2875L12.5004 9.71248L18.1123 15.2875" stroke="#445277" stroke-width="1.49661"/>
	</svg>
								</span>
							</a>
							<div class="footnotes">
								<?php echo $footnotes; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta-button' ); ?>

<?php get_footer(); ?>