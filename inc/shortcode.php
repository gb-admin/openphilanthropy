<?php
/**
 * Address
 */
function shortcode_address( $atts ) {
	extract( shortcode_atts(
		array(
			'google-map' => null,
			'hide-email' => null,
			'hide-title' => null,
			'title' => null
		), $atts, 'address'
	) );

	$address_title = get_field( 'address_title', 'option' );
	$address_street = get_field( 'address_street', 'option' );
	$address_street_2 = get_field( 'address_street_2', 'option' );
	$address_city = get_field( 'address_city', 'option' );
	$address_state = get_field( 'address_state', 'option' );
	$address_zip_code = get_field( 'address_zip_code', 'option' );
	$address_email = get_field( 'address_email', 'option' );
	$address_phone = get_field( 'address_phone', 'option' );

	if ( $atts['email'] ) {
		$address_email = $atts['email'];
	}

	if ( $atts['title'] ) {
		$address_title = $atts['title'];
	}

	$google_map_title = $address_title;

	$html__address_location_close = '</span>';
	$html__address_location_open = '<span class="address__location">';

	if ( $atts['google-map-title'] ) {
		$google_map_title = $atts['google-map-title'];
	}

	if ( $address_street ) {
		$google_map_street = ', ' . $address_street;
	}

	if ( $address_street_2 ) {
		$google_map_street_2 = ', ' . $address_street_2;
	}

	if ( $address_city ) {
		$google_map_city = ', ' . $address_city;
	}

	if ( $address_state ) {
		$google_map_state = ', ' . $address_state;
	}

	if ( $address_zip_code ) {
		$google_map_zip_code = ', ' . $address_zip_code;
	}

	if ( $atts['google-map'] ) {
		$html__address_location_close = '</a>';
		$html__address_location_open = '<a class="address__location" href="https://maps.google.com/?q=' . $google_map_title . $google_map_street . $google_map_street_2 . $google_map_city . $google_map_state . $google_map_zip_code . '" target="_blank">';
	}

	if ( $address_email && $atts['hide-email'] == false ) {
		$html__address_email = '<div class="address__email">
			<a href="mailto:' . $address_email . '" itemprop="email">' . $address_email . '</a>
		</div>';
	}

	if ( $address_title && $atts['hide-name'] == false && $atts['hide-title'] == false ) {
		$html__address_title = '<div class="address__name">
			<span itemprop="name">' . $address_title . '</span>
		</div>';
	}

	$html = '<div class="address" itemscope itemtype="http://schema.org/Organization">
		' . $html__address_title . '
		<address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			' . $html__address_location_open . '
				<span class="address__street" itemprop="streetAddress">125 Whipple Street</span><br>
				<span class="address__city" itemprop="addressLocality">Providence</span>, <span itemprop="addressRegion">RI</span> <span itemprop="postalCode">02908</span>
			' . $html__address_location_close . '
			<a href="tel:' . $address_phone . '" class="address__phone" itemprop="telephone" content="' . $address_phone . '">' . $address_phone . '</a>
		</address>
		' . $html__address_email . '
	</div>';

	return $html;
}

add_shortcode( 'address', 'shortcode_address' );

/**
 * Button
 */
function shortcode_button( $atts ) {
	extract( shortcode_atts(
		array(
			'link' => null,
			'page' => null,
			'text' => 'Button'
		), $atts, 'button'
	) );

	if ( $link ) {
		$href = $link;
	} elseif ( $page ) {
		$href = '/' . str_replace( ' ', '-', $page );
	} else {
		$href = '#';
	}

	return '<a class="button" href="' . $href . '">' . $text . '</a>';
}

add_shortcode( 'button', 'shortcode_button' );

/**
 * Policy
 */
function shortcode_policy() {
	$policy = get_field( 'policy', 'options' );

	$html = '<div class="policy">
		<div class="entry-content">
			' . $policy . '
		</div>
	</div>';

	return $html;
}

add_shortcode( 'policy', 'shortcode_policy' );

/**
 * Site Map
 */
function shortcode_site_map() {
	$exclude = [];

	$pages = get_pages();

	foreach ( $pages as $i ) {
		if ( stristr( $i->post_title, 'Site Map' ) ) {
			$exclude[] = $i->ID;
		}

		if ( stristr( $i->post_title, 'Thank You' ) ) {
			$exclude[] = $i->ID;
		}
	}

	if ( get_page_by_title( '404' ) ) {
		$exclude[] = get_page_by_title( '404' )->ID;
	}

	$pages = wp_list_pages( array(
		'echo' => 0,
		'exclude' => implode( ',', $exclude ),
		'title_li' => ''
	) );

	$html = '<ul class="site-map">' . $pages . '</ul>';

	return $html;
}

add_shortcode( 'site-map', 'shortcode_site_map' );