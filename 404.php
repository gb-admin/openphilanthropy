<?php
	get_header();

	get_template_part( 'part/page', 'header-404' );
?>

<div class="content-404">
	<div class="wrap">
		<div class="content-404__main">
			<h2>Try searching for another page</h2>

			<p>(page dev in progress)</p>

			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>