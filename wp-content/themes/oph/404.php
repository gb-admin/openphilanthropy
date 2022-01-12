<?php
	get_header();

	get_template_part( 'part/page', 'header-404' );
?>

<div class="content-404">
	<div class="wrap">
		<div class="content-404__main">
			<h2>Try searching for another page using the search form below.</h2>

			<div class="search-form-box">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>