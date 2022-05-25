<?php
$view_list = false; 

if ( isset( $_GET['view-list'] ) && $_GET['view-list'] == 'true' ) {
	$view_list = true;
}

$clear_categories_href = '?#categories'; 

if ( $view_list ) { 
	$clear_categories_href = '?view-list=true#categories'; 
} 

$theURL = home_url( add_query_arg( null, null )); 
$filters = array(); 
$ignore = array("items", "sort", "view-list"); 
$params = get_url_params(); 

foreach( $params as $p => $val ) { 
	if ( !in_array($p, $ignore) && !empty($p) && !empty($val[0]) ) { 
		$filters[$p] = $val;
	}
} 

if ( !empty($filters) ) { 
?>
	<div class="page-header-categories has-categories" id="categories">
		<div class="wrap">
			<div class="page-header-categories__content">
				<nav aria-label="Filter Categories List">
					<ul id="filter-categories-list">
						<?php  
						foreach( $filters as $key => $val ) { 
							$i = 0; 
							$items = count($val); 
							while( $i < $items ) {
								$tax_slug = $val[$i]; 
								$tax_type = $key; 
								$term = get_term_by('slug', $tax_slug, $tax_type); 
								if ( empty( $term ) ) {
									$term_name = $tax_slug; 
									if ( $key == 'amount' ) { 
										switch ( $term_name ) {
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
								$escURL = str_replace($query, '', $theURL); 
								?>
								<li data-category="<?php echo $tax_type; ?>">
									<a href="<?php echo $escURL; ?>"><?php echo $term_name; ?> <svg aria-hidden="true" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M7.857 6.506L1.571.221.157 1.635 6.443 7.92 0 14.363l1.414 1.415 6.443-6.443 6.442 6.442 1.415-1.414L9.27 7.92l6.285-6.285L14.142.221 7.857 6.506z"/></svg></a>
								</li>
							<?php 
								 $i++;
							}
						}
						?>
					</ul>

					<a class="clear-categories" href="<?php echo $clear_categories_href; ?>">
						Clear All <svg aria-hidden="true" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M7.857 6.506L1.571.221.157 1.635 6.443 7.92 0 14.363l1.414 1.415 6.443-6.443 6.442 6.442 1.415-1.414L9.27 7.92l6.285-6.285L14.142.221 7.857 6.506z"/></svg>
					</a>
				</nav>
			</div>
		</div>
	</div>
<?php 
}
