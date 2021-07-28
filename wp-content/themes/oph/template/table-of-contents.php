<?php
	/**
	 * Template Name: Table of Contents
	 */

	the_post();

	get_header();

	$content_sections = get_field( 'content_sections' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-table-of-contents">
	<div class="wrap">
		<div class="content-table-of-contents__main">
			<?php if ( $content_sections ) : ?>
				<div class="content-table-of-contents__aside pagenav-aside">
					<h3>Navigate this page with the links below</h3>

					<ul aria-label="Steps Navigation List" class="aside-steps-navigation" id="steps-navigation-list">
						<?php foreach ( $content_sections as $k => $i ) : $k = $k + 1; ?>
							<li>
								<h6>
									<a data-goto="#<?php echo $title_href; ?>" href="#<?php echo $title_href; ?>" title="Stage <?php echo $k; ?>">Stage <?php echo $k; ?>:</a>
								</h6>

								<h4>
									<a data-goto="#<?php echo $title_href; ?>" href="#<?php echo $title_href; ?>" title="<?php echo $i['title']; ?>">
										<?php echo $i['title']; ?> <svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
									</a>
								</h4>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( $content_sections ) : ?>
				<div class="content-table-of-contents__entry pagenav-content">
					<div class="content-table-of-contents__content">
						<?php foreach ( $content_sections as $k => $i ) : ?>
							<?php if ( $i['content'] && $i['section_title'] ) : $k = $k + 1; ?>
								<div class="content-table-of-contents__section">
									<div class="section-title">
										<h2 id="section-<?php echo $k; ?>"><?php echo $k . '. ' . $i['section_title']; ?></h2>
									</div>

									<?php foreach ( $i['content'] as $n => $c ) : ?>

										<?php
											$n = $n + 1;
										?>

										<div class="section-content">
											<h4 id="content-<?php echo $k . '.' . $n; ?>"><?php echo $k . '.' . $n . $c['title']; ?></h4>

											<div>
												<?php echo $c['entry']; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta-button' ); ?>

<?php get_footer(); ?>