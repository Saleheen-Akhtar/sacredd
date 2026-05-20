<?php
/**
 * Custom image sizes
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_setup_image_sizes() {
	add_theme_support( 'post-thumbnails' );

	// Hero layers, cards, etc.
	add_image_size( 'sk-hero-layer', 1920, 1080, true );
	add_image_size( 'sk-card', 800, 600, true );
	add_image_size( 'sk-card-portrait', 600, 800, true );
}
add_action( 'after_setup_theme', 'sk_setup_image_sizes' );
