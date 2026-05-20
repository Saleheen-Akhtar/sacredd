<?php
/**
 * Enqueue scripts and styles
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'sk-tokens', get_theme_file_uri( 'assets/css/tokens.css' ), array(), $theme_version );
	wp_enqueue_style( 'sk-reset', get_theme_file_uri( 'assets/css/reset.css' ), array( 'sk-tokens' ), $theme_version );
	wp_enqueue_style( 'sk-base', get_theme_file_uri( 'assets/css/base.css' ), array( 'sk-reset' ), $theme_version );
	wp_enqueue_style( 'sk-motion', get_theme_file_uri( 'assets/css/motion.css' ), array( 'sk-base' ), $theme_version );
	wp_enqueue_style( 'sk-layout', get_theme_file_uri( 'assets/css/layout.css' ), array( 'sk-base' ), $theme_version );
	wp_enqueue_style( 'sk-utilities', get_theme_file_uri( 'assets/css/utilities.css' ), array( 'sk-base' ), $theme_version );

	// Enqueue built JS file
	wp_enqueue_script( 'sk-main', get_theme_file_uri( 'dist/js/main.js' ), array(), $theme_version, true );
}
add_action( 'wp_enqueue_scripts', 'sk_enqueue_scripts' );
