<?php

/**
 * Sanitize text to remove any listed characters
 *
 * @param [String] $text
 * @param [String or Array] $characters_to_remove
 * @return String
 */
function oph_filter(String $text, $characters_to_remove)
{
	if ( !$characters_to_remove ) return $text;

	return str_replace($characters_to_remove, "", $text);
}