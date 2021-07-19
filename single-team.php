<?php
	the_post();

	get_header();

	$post_thumbnail = get_the_post_thumbnail_url( $post->ID, 'lg' );
?>

<div class="content-single-team" id="team-member">
	<div class="wrap">
		<div class="content-single-team__main">
			<div class="content-single-team__aside"></div>

			<div class="content-single-team__entry"></div>
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta', 'button' ); ?>

<?php get_footer(); ?>