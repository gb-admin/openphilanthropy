<?php
$sort_params = [
	'high-to-low'      => 'Highest to lowest',
	'low-to-high'      => 'Lowest to highest',
	'a-z'              => 'A - Z',
	'recent'           => 'Newest to oldest',
	'oldest-to-newest' => 'Oldest to newest'
];
?>

<div class="feed-options-bar feed-options-bar--mobile">
	<div class="wrap">
		<nav aria-label="Feed Options Bar">
			<div class="dropdown">
				<button class="button" href="#">
					Sort <?php if ( isset($_GET['sort']) ) echo "({$sort_params[$_GET['sort']]}) &nbsp;"; ?>
					<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
				</button>

				<ul class="dropdown-content">
                                        <?php if (is_page_template('template/research.php')) : ?>
                                                <li>
                                                        <a href="<?php echo esc_url(add_query_arg('sort', 'a-z')); ?>#categories"><?= $sort_params['a-z']; ?></a>
                                                </li>
                                        <?php endif; ?>
                                        <?php if (is_page_template('template/grants.php')) : ?>
                                                <li>
                                                        <a href="<?php echo esc_url(add_query_arg('sort', 'high-to-low')); ?>#categories"><?= $sort_params['high-to-low']; ?></a>
                                                </li>
                                                <li>
                                                        <a href="<?php echo esc_url(add_query_arg('sort', 'low-to-high')); ?>#categories"><?= $sort_params['low-to-high']; ?></a>
                                                </li>
					<?php endif; ?>
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

			<button class="button button--solid button-view-list">
				<?php echo oph_display_type('grid'); ?>
			</button>
		</nav>
	</div>
</div>
