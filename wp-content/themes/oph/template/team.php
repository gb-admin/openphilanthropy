<?php
	/**
	 * Template Name: Team
	 */

	the_post();

	get_header();

	$team = new WP_Query( array(
		'post_type' => 'team',
		'posts_per_page' => -1,
		'order' => 'desc',
		'orderby' => 'date'
	) );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-team" id="team">
	<div class="wrap">
		<div class="content-team__main">
			<?php if ( $team->have_posts() ) : ?>
				<ul class="list-team" id="team-list">
					<?php while ( $team->have_posts() ) : $team->the_post(); ?>

						<?php
							$team_title = get_field( 'team_title' );
						?>

						<li>
							<a href="<?php echo get_permalink(); ?>">
								<h4><?php echo the_title(); ?></h4>

								<?php if ( $team_title ) : ?>
									<h6><?php echo $team_title; ?></h6>
								<?php endif; ?>

								<div aria-hidden="true" class="list-team__icon">
									<svg viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.55 1L34 8.5 26.55 16M0 8.5h34" stroke="#6e7ca0" stroke-width="2"/></svg>
								</div>
							</a>
						</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta-button' ); ?>

<?php get_footer(); ?>