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

					<nav aria-label="Content Navigation" id="content-navigation">
						<ul class="list-content-navigation" id="content-navigation-list">
							<?php foreach ( $content_sections as $k => $i ) : $k = $k + 1; ?>
								<li>
									<h4>
										<a data-goto="#section-<?php echo $k; ?>" href="#section-<?php echo $k; ?>" title="<?php echo $i['section_title']; ?>">
											<?php echo $k . '. ' . $i['section_title']; ?> <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
										</a>
									</h4>

									<?php if ( $i['content'] ) : ?>
										<ul>
											<?php foreach ( $i['content'] as $n => $c ) : $n = $n + 1; ?>
												<li>
													<h5>
														<a data-goto="#content-<?php echo $n; ?>" href="#content-<?php echo $n; ?>"><?php echo $k . '.' . $n . ' ' . $c['title']; ?></a>
													</h5>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
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

									<?php foreach ( $i['content'] as $n => $c ) : $n = $n + 1; ?>
										<div class="section-content">
											<h4 id="content-<?php echo $k . '.' . $n; ?>"><?php echo $k . '.' . $n . ' ' . $c['title']; ?></h4>

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