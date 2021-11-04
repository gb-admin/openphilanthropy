<?php
	$post_type = '';

	if ( isset( $args['post_type'] ) ) {
		$post_type = $args['post_type'];
	}

	$research_page = get_page_by_path( 'research' );

	$is_research_page = '';
	$research_page_id = '';

	if ( $research_page && $research_page->ID ) {
		$research_page_id = $research_page->ID;
	}

	if ( $research_page_id == get_the_ID() ) {
		$is_research_page = true;
	}

	$sort_params = [
		'high-to-low'      => 'High to lowest',
		'a-z'              => 'A - Z',
		'recent'           => 'Newest to oldest',
		'oldest-to-newest' => 'Oldest to newest'
	];
?>

<div class="feed-options-bar">
	<div class="wrap">
		<nav aria-label="Feed Options Bar">
			<div class="dropdown">
				<button class="button" href="#">
					Sort <?php if ( isset($_GET['sort']) ) echo "({$sort_params[$_GET['sort']]}) &nbsp;"; ?>
					<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
				</button>

				<ul class="dropdown-content">
					<?php if ( ! $is_research_page ) : ?>
						<li>
							<a href="<?php echo esc_url( add_query_arg( 'sort', 'high-to-low' ) ); ?>#categories"><?= $sort_params['high-to-low']; ?></a>
						</li>
					<?php endif; ?>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'sort', 'a-z' ) ); ?>#categories"><?= $sort_params['a-z']; ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'sort', 'recent' ) ); ?>#categories"><?= $sort_params['recent']; ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'sort', 'oldest-to-newest' ) ); ?>#categories"><?= $sort_params['oldest-to-newest']; ?></a>
					</li>
				</ul>
			</div>

			<div class="dropdown dropdown--inline-content">
				<button class="button" href="#">
					Items <?php if ( isset($_GET['items']) ) echo "({$_GET['items']})"; ?>
					<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
				</button>

				<ul class="dropdown-content">
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'items', '25' ) ); ?>#categories">25</a>
					</li>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'items', '50' ) ); ?>#categories">50</a>
					</li>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'items', '100' ) ); ?>#categories">100</a>
					</li>
				</ul>
			</div>

			<?php if ( $post_type == 'research' || is_page_template( 'template/research-category.php' ) ) : ?>
				<button class="button button--solid button-view-list">
					<?php echo oph_display_type('list'); ?>
				</button>
			<?php else : ?>
				<button class="button button--solid button-view-list">
					<?php echo oph_display_type('grid'); ?>
				</button>
			<?php endif; ?>
		</nav>
	</div>
</div>