<div class="feed-options-bar feed-options-bar--mobile">
	<div class="wrap">
		<nav aria-label="Feed Options Bar">
			<div class="dropdown">
				<button class="button" href="#">
					Sort <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
				</button>

				<ul class="dropdown-content">
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'sort', 'high-to-low' ) ); ?>#categories">Highest to lowest</a>
					</li>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'sort', 'a-z' ) ); ?>#categories">A to Z</a>
					</li>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'sort', 'recent' ) ); ?>#categories">Newest to oldest</a>
					</li>
				</ul>
			</div>

			<div class="dropdown dropdown--inline-content">
				<button class="button" href="#">
					Items <svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
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

			<button class="button button--solid">View all as list</button>
		</nav>
	</div>
</div>