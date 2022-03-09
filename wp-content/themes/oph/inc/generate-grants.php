<?php 
/**
 * Export Grants to CSV 
 *
 * @param array $grants_args 
 *  get_posts() args for grants posts
 * @param array $grants_query 
 *  get_posts results 
 * 
 */

function generate_grants_csv() { 

  // nonce value set in filter-sidebar.php 
  if ( !wp_verify_nonce( $_REQUEST['nonce'], "generate_grants_csv_nonce")) {
    exit("Oh no you don't.");
  }   

  $grants_args = array(
    'post_type' => 'grants', 
    'order' => 'DESC',
    'orderby' => 'date', 
    'posts_per_page' => -1,
    'post_status' => 'publish'
  ); 

  global $post;
  $grants_query = get_posts( $grants_args ); 

  if ($grants_query) {

    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="OpenPhilGrants.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $file = fopen('php://output', 'w');

    fputcsv($file, array('Grant', 'Organization Name', 'Focus Area', 'Amount', 'Date'));

    foreach ($grants_query as $post) {
      setup_postdata($post);
      // Grant 
      $grant_name = get_the_title();
      // Organization Name(s) 
      $org_terms = get_the_terms( $post->ID, 'organization-name' );
      $org_array = array();
      if (!empty($org_terms)) {
        foreach ( $org_terms as $term ) {
          $org_array[] = $term->name;
        }
      }
      $grant_org = implode(",", $org_array); 
      // Focus Area(s) 
      $focus_terms = get_the_terms( $post->ID, 'focus-area' ); 
      $focus_array = array();
      if (!empty($focus_terms)) {
        foreach ( $focus_terms as $term ) {
          $focus_array[] = $term->name;
        }
      }
      $grant_focus = implode(",", $focus_array);
      // Grant Amount 
      $grant_amount = get_field('grant_amount'); 
      // Award Date 
      $grant_date = get_field('award_date');
      if( $grant_date ){
        $date = DateTime::createFromFormat('m/d/Y', $grant_date);
        $grant_date = $date->format('F Y');
      }

      fputcsv($file, array($grant_name, $grant_org, $grant_focus, $grant_amount, $grant_date)); 
    }
    exit();
  }
}

add_action("wp_ajax_generate_grants", "generate_grants_csv");
add_action("wp_ajax_nopriv_generate_grants", "generate_grants_csv");