<?php
	/**
	 * Template Name: Careers
	 */

	the_post();

	get_header();

	$careers = new WP_Query( array(
		'post_type' => 'careers',
		'posts_per_page' => -1,
		'order' => 'desc',
		'orderby' => 'date'
	) );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-careers" id="careers">
	<div class="wrap">
		<div class="content-careers__main"></div>
	</div>
</div>

<?php get_template_part( 'part/cta-button' ); ?>

<?php get_footer(); ?>