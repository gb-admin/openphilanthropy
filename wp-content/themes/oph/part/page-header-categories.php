<?php
$view_list = false;

if (isset($_GET['view-list']) && $_GET['view-list'] == 'true') {
	$view_list = true;
}

$clear_categories_href = '?#categories';

if ($view_list) {
	$clear_categories_href = '?view-list=true#categories';
}

$return_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
$return_url = $return_url . $_SERVER["REQUEST_URI"];
$return_url = explode("?", $return_url)[0];
$return_url = explode("page", $return_url)[0];

$theURL = home_url(add_query_arg(null, null));
$filters = array();
$ignore = array("items", "sort", "view-list");
$params = get_url_params();

foreach ($params as $p => $val) {
	if (!in_array($p, $ignore) && !empty($p) && !empty($val[0])) {
		$filters[$p] = $val;
	}
}

if (!empty($filters)) {
?>
	<div class="page-header-categories has-categories" id="categories">
		<div class="wrap">
			<div class="page-header-categories__content">
				<nav aria-label="Filter Categories List">
					<ul id="filter-categories-list">
						<?php
						foreach ($filters as $key => $val) {
							$i = 0;
							$items = count($val);
							while ($i < $items) {
								$tax_slug = $val[$i];
								$tax_type = $key;
								$tax_type_temp = str_replace('[]', '', $tax_type);
								$term = get_term_by('slug', $tax_slug, $tax_type_temp);
								if (empty($term)) {
									$term_name = $tax_slug;
									if ($key == 'amount') {
										switch ($term_name) {
											case 'less-than-1hundthous':
												$term_name = 'Less than $100,000';
												break;
											case 'between-1hundthous-1mil':
												$term_name = 'Between $100,000 and $1,000,000';
												break;
											case 'greater-than-1mil':
												$term_name = 'Greater than $1,000,000';
												break;
										}
									}
								} else {
									$term_name = $term->name;
								}

								$query = $tax_type . '=' . str_replace(' ', '+', $tax_slug);
								$query = str_replace('[', '%5B', $query);
								$query = str_replace(']', '%5D', $query);
								$param_url = explode("/?", $_SERVER["REQUEST_URI"])[1];
								// $param_url = str_replace('%5B0%5D', '%5B%5D', $param_url);
								$esc_query = str_replace($query, '', $param_url);
								// var_dump($return_url); 
								// var_dump($esc_query); 
								// $esc_query = str_replace('&&', '&', $esc_query); 
								$temp_term = get_term_by('slug', $term_name);

						?>
								<li data-category="<?php echo $tax_type; ?>">
									<a href="<?php echo $return_url . '?' . $esc_query; ?>"><?php echo ucwords(str_replace('-', ' ', $term_name)); ?> <svg aria-hidden="true" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
											<path d="M7.857 6.506L1.571.221.157 1.635 6.443 7.92 0 14.363l1.414 1.415 6.443-6.443 6.442 6.442 1.415-1.414L9.27 7.92l6.285-6.285L14.142.221 7.857 6.506z" />
										</svg></a>
								</li>
						<?php
								$i++;
							}
						}
						?>
					</ul>

					<a class="clear-categories" href="<?php echo $return_url; ?>">
						Clear All <svg aria-hidden="true" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
							<path d="M7.857 6.506L1.571.221.157 1.635 6.443 7.92 0 14.363l1.414 1.415 6.443-6.443 6.442 6.442 1.415-1.414L9.27 7.92l6.285-6.285L14.142.221 7.857 6.506z" />
						</svg>
					</a>
				</nav>
			</div>
		</div>
	</div>
<?php
}
