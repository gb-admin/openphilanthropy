<?php
	$page_404 = get_page_by_title( '404' );

	$page_404_id = get_the_ID();

	if ( $page_404 && ! is_wp_error( $page_404 ) && $page_404->ID ) {
		$page_404_id = $page_404->ID;
	}

	$page_header_button = get_field( 'page_header_button', $page_404_id );
	$page_header_content = get_field( 'page_header_content', $page_404_id );
	$page_header_image = get_field( 'page_header_image', $page_404_id );
	$page_header_title = get_field( 'page_header_title', $page_404_id );

	if ( ! $page_header_title ) {
		$page_header_title = get_the_title();
	}
?>

<div class="page-header page-header--404">
	<div class="wrap">
		<div class="page-header__content">
			<?php if ( $page_header_image ) : ?>
				<div class="page-header__image">
					<img src="<?php echo $page_header_image['sizes']['lg']; ?>" alt="">
				</div>
			<?php endif; ?>

			<div class="page-header__main">
				<h1><?php echo $page_header_title; ?></h1>

				<?php if ( $page_header_content ) : ?>
					<div class="entry-content">
						<?php echo $page_header_content; ?>
					</div>
				<?php endif; ?>

				<?php if ( $page_header_button ) : ?>
					<div class="button-group">
						<?php foreach ( $page_header_button as $i ) : ?>
							<?php if ( $i['link']['url'] ) : ?>
								<a class="button" href="<?php echo $i['link']['url']; ?>"<?php if ( $i['link']['target'] == '_blank' ) { echo ' target="_blank"'; } ?>><?php echo $i['link']['title']; ?></a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>