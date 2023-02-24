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
    exit("This page currently isn't working. We'd be grateful if you could contact webrequests@openphilanthropy.org to let us know you encountered this error. Thanks!");
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

    // making the CSV work with the ever-cranky excel 
    fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    fputcsv($file, array('Grant', 'Organization Name', 'Focus Area', 'Amount', 'Date'));

    foreach ($grants_query as $post) {
      setup_postdata($post);
      // Grant 
      $grant_name = get_the_title();
      $grant_name = html_entity_decode($grant_name);
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

      if ( !empty($focus_terms) ) { 
        $grant_focus = $focus_terms[0]->name; 

        foreach ( $focus_terms as $term ) {
          if( $term->name == 'Science for Global Health' || $term->name == 'Transformative Basic Science' || $term->name == 'South Asian Air Quality' ) { 
            $grant_focus = $term->name; 
          } 
        } 
      } 
      $grant_focus = html_entity_decode($grant_focus);
      /*
      $focus_array = array();
      if (!empty($focus_terms)) {
        foreach ( $focus_terms as $term ) {
          $focus_array[] = $term->name;
        }
      }
      $grant_focus = implode(",", $focus_array);
      */

      // Grant Amount 
      $grant_amount = get_field('grant_amount'); 
      if( $grant_amount ){
        $grant_amount = '$' . number_format($grant_amount);
      }
      // Award Date 
      $grant_date = get_field('award_date');
      if( $grant_date ){
        $date = DateTime::createFromFormat('F j, Y', $grant_date);
        $grant_date = $date->format('F Y');
      }

      fputcsv($file, array($grant_name, $grant_org, $grant_focus, $grant_amount, $grant_date)); 


    }
    exit();
  }
}

add_action("wp_ajax_generate_grants", "generate_grants_csv");
add_action("wp_ajax_nopriv_generate_grants", "generate_grants_csv");
