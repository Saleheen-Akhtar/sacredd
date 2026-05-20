<?php
/**
 * Helper Functions
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_option( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

function sk_image( $path ) {
	return get_theme_file_uri( 'assets/images/' . $path );
}
