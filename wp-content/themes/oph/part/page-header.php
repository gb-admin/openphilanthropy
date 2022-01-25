<?php
	$page_header_button = get_field( 'page_header_button' );
	$page_header_content = get_field( 'page_header_content' );
	$page_header_image = get_field( 'page_header_image' );
	$page_header_title = get_field( 'page_header_title' );

	if ( ! $page_header_title ) {
		$page_header_title = get_the_title();
	}

	$focus_area_image = '';

	$terms_focus_area = get_the_terms( $post->ID, 'focus-area' );

	if ( ! is_wp_error( $terms_focus_area ) ) {
		$focus_area_image = get_field( 'category_image', 'focus-area_' . $terms_focus_area[0]->term_id );
	}

	if ( ! $page_header_image && $focus_area_image ) {
		$page_header_image = $focus_area_image;
	}

	$page_header_class = [];

	if ( $page_header_image ) {
		array_push( $page_header_class, 'has-image' );
	}

	if ( is_single() ) {
		array_push( $page_header_class, 'is-single' );
	} 

	if ( is_singular('grants') ) {
		$orgSite =  get_field('org_website', $post->ID); 
	}
?>
<div class="page-header<?php echo ' ' . inline_list( $page_header_class, ' ' ); ?>">
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

				<?php if ( $page_header_button ) { ?>
					<div class="button-group">
						<?php foreach ( $page_header_button as $i ) : ?>
							<?php if ( $i['link']['url'] ) : ?>
								<a class="button" href="<?php echo $i['link']['url']; ?>"<?php if ( $i['link']['target'] == '_blank' ) { echo ' target="_blank"'; } ?>><?php echo $i['link']['title']; ?></a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php } elseif ( $orgSite ) {  ?> 
					<div class="button-group">						
						<a class="button" href="<?php echo $orgSite; ?>" target="_blank">Organization Site</a> 
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</div>