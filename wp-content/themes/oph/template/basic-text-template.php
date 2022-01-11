<?php
	/**
	 * Template Name: Basic Text Template
	 */

	the_post();

	get_header();

	$footnotes = get_field( 'footnotes' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-basic-text">
	<div class="wrap">
		<div class="content-basic-text__main">
			<?php the_content(); ?>

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

<?php
	$call_to_action_button = get_field( 'call_to_action_button' );
?>

<div class="cta-button" id="button">
	<div class="wrap">
		<div class="cta-button__content">
			<div class="button-group">
				<?php if ( ! empty( $call_to_action_button ) ) : ?>
					<?php foreach ( $call_to_action_button as $button ) : ?>
						<a class="button" href="<?php echo $button['link']['url']; ?>"><?php echo $button['link']['title']; ?></a>
					<?php endforeach; ?>
				<?php else : ?>
					<a class="button" href="/grants">Back to Grants Database</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>