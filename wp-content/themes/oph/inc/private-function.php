<?php
/**
 * Return $array if $key equal to $value.
 */
function array_key_index( $array = null, $key = null, $value = null ) {
	if ( is_array( $array ) ) {
		$index = $array[0];

		if ( $array ) {
			foreach ( $array as $i ) {
				if ( $value == $i[ $key ] ) {
					$index = $i;

					break;
				}
			}
		}

		return $index;
	}
}

/**
 * Print Array.
 */
function pr( $var ) {
	$style = '
	margin: 16px 0;
	padding: 8px 12px;
	background: #ffdc00;
	border-radius: 6px;
	box-shadow: 0 2px 3px rgba(0, 0, 0, .23);
	font-family: Consolas, Lucida Console, monospace;
	font-size: 12px;
	font-weight: 700;
	line-height: 1.75;
	color: #111;
	text-align: left;
	overflow: scroll;
	position: relative;
	z-index: 99999;
	';

	echo '<pre style="' . $style . '">';
	print_r( $var );
	echo '</pre>';
}