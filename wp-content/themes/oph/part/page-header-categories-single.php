<?php
	$post_type = get_post_type();
	$terms_content_type = get_the_terms( $post->ID, 'content-type' );
	$terms_focus_area = get_the_terms( $post->ID, 'focus-area' );
?>

<?php if ( $terms_content_type || $terms_focus_area ) : ?>
	<div class="single-header-categories" id="categories">
		<div class="wrap">
			<div class="single-header-categories__content">
				<nav aria-label="Post Categories List">
					<ul id="single-header-categories-list">
						<?php if ( $terms_content_type && ! is_wp_error( $terms_content_type ) ) : ?>
							<?php foreach ( $terms_content_type as $term ) : ?>
								<li>
									<a href="/<?php echo $post_type; ?>?content-type=<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( $terms_focus_area && ! is_wp_error( $terms_focus_area ) ) : ?>
							<?php foreach ( $terms_focus_area as $term ) : ?>
								<li>
									<a href="/<?php echo $post_type; ?>?focus-area=<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
<?php endif; ?>