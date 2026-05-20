<?php
/**
 * Sacred Kompass functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Thin loader
require_once get_theme_file_path( 'inc/helpers.php' );
require_once get_theme_file_path( 'inc/admin-options.php' );
require_once get_theme_file_path( 'inc/enqueue.php' );
require_once get_theme_file_path( 'inc/cpt-register.php' );
require_once get_theme_file_path( 'inc/blocks-register.php' );
require_once get_theme_file_path( 'inc/image-sizes.php' );
require_once get_theme_file_path( 'inc/rest-extensions.php' );
