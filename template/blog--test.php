<?php
	/**
	 * Template Name: Blog
	 */

	the_post();

	get_header();
?>

<?php get_template_part( 'part/hero' ); ?>

<?php
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	$featured_post = get_field( 'featured_post' );

	$featured_post_id = [];

	if ( $featured_post ) {
		array_push( $featured_post_id, $featured_post->ID );
	}

	$blog = new WP_Query( array(
		'post_type' => 'blog',
		'posts_per_page' => 4,
		'order' => 'desc',
		'orderby' => 'date',
		'paged' => $paged,
		'post__not_in' => $featured_post_id
	) );

	$blog_featured_image = get_the_post_thumbnail_url( $featured_post->ID, 'lg' );

	$blog_featured_excerpt_source = apply_filters( 'the_content', get_post_field( 'post_content', $featured_post->ID ) );

	$blog_featured_excerpt = array(
		'append' => '....<a class="excerpt-link" href="' . get_permalink( $featured_post->ID ) . '">Read&nbsp;More</a>',
		'limit' => 43,
		'limitby' => 'word',
		'source' => $blog_featured_excerpt_source
	);
?>

<div id="blog-featured-post">
	<span class="wrap slim">
		<div class="blog-feature-box">
			<div class="blog-feature-box__head" style="background-image: url(<?php echo $blog_featured_image; ?>);">
				<span aria-hidden="true" class="blog-feature-box__head-flag">
					<span class="blog-feature-box__head-flag-text">
						Featured Blog Post
					</span>
				</span>

				<div class="blog-feature-box__head-content">
					<h6 class="blog-feature-box__date">October 7, 2019</h6>

					<h2 class="blog-feature-box__title"><a href="<?php echo get_permalink( $featured_post->ID ); ?>"><?php echo $featured_post->post_title; ?></a></h2>
				</div>

				<span class="blog-feature-box__head-mask"></span>
			</div>

			<div class="blog-feature-box__body">
				<div class="blog-feature-box__body-content">
					<p>
						<?php echo excerpt( $blog_featured_excerpt ); ?>
					</p>
				</div>

				<div class="blog-feature-box__body-details">
					<span class="blog-feature-box__author">
						By <span class="blog-feature-box__author-name">Teah Hayward</span>
					</span>

					<span class="comments-label">
						<a href="<?php echo get_permalink( $featured_post->ID ); ?>#comments">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 20"><path d="M18.652 0H2.525C1.13 0 0 1.13 0 2.525v9.656c0 1.395 1.13 2.525 2.525 2.525h5.122L14.706 20l.038-5.294h3.908c1.394 0 2.524-1.13 2.524-2.525V2.525C21.176 1.13 20.046 0 18.652 0m0 1.176c.743 0 1.348.605 1.348 1.349v9.656c0 .744-.605 1.348-1.348 1.348h-5.076l-.009 1.169-.021 2.961-5.193-3.894-.314-.236H2.525c-.744 0-1.349-.604-1.349-1.348V2.525c0-.744.605-1.349 1.349-1.349h16.127"/></svg><span class="comments-label__text"><span class="comments-label__count"><?php echo get_comments_number( $featured_post->ID ); ?></span> Comments</span>
						</a>
					</span>
				</div>
			</div>
		</div>
	</span>
</div>

<?php if ( $blog->have_posts() ) : ?>
	<div id="blog-feed">
		<span class="wrap slim">
			<span class="blog-feed-grid">
				<?php while ( $blog->have_posts() ) : $blog->the_post(); ?>

					<?php
						$author_name = get_field( 'author_name', $blog->ID );

						$blog_excerpt_source = apply_filters( 'the_content', get_post_field( 'post_content', $blog->ID ) );

						$blog_excerpt = array(
							'append' => '....<a class="blog-list-post__excerpt-link" href="' . get_permalink() . '">Read More</a>',
							'limit' => 76,
							'limitby' => 'word',
							'source' => $blog_excerpt_source
						);

						$blog_image = get_the_post_thumbnail_url( $blog->ID, 'lg' );
					?>

					<span class="blog-feed-cell">
						<span class="blog-feed-post">
							<a class="blog-feed-post__image" href="<?php echo get_permalink(); ?>" title="" style="background-image: url(<?php echo $blog_image; ?>);"></a>

							<h6 class="blog-feed-post__date"><?php echo get_the_date( 'F j, Y', $blog->ID ); ?></h6>

							<h3 class="blog-feed-post__title">
								<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
							</h3>

							<p>
								<?php echo excerpt( $blog_excerpt ); ?>
							</p>

							<span class="blog-feed-post__footer">
								<?php if ( $author_name ) : ?>
									<span class="blog-feed-post__author">
										By <span class="blog-feed-post__author-name"><?php echo $author_name; ?></span>
									</span>
								<?php endif; ?>

								<span class="comments-label">
									<a href="<?php echo get_permalink(); ?>#comments">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 20"><path d="M18.652 0H2.525C1.13 0 0 1.13 0 2.525v9.656c0 1.395 1.13 2.525 2.525 2.525h5.122L14.706 20l.038-5.294h3.908c1.394 0 2.524-1.13 2.524-2.525V2.525C21.176 1.13 20.046 0 18.652 0m0 1.176c.743 0 1.348.605 1.348 1.349v9.656c0 .744-.605 1.348-1.348 1.348h-5.076l-.009 1.169-.021 2.961-5.193-3.894-.314-.236H2.525c-.744 0-1.349-.604-1.349-1.348V2.525c0-.744.605-1.349 1.349-1.349h16.127"/></svg><span class="comments-label__text"><span class="comments-label__count"><?php echo get_comments_number( $blog->ID ); ?></span> Comments</span>
									</a>
								</span>
							</span>
						</span>
					</span>
				<?php endwhile; ?>
			</span>
		</span>
	</div>
<?php endif; ?>

<?php get_footer(); ?>