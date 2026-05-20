<?php
/**
 * Register Gutenberg blocks
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_register_blocks() {
	$blocks_dir = get_theme_file_path( 'blocks' );

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$blocks = array_diff( scandir( $blocks_dir ), array( '..', '.' ) );

	foreach ( $blocks as $block ) {
		$block_path = $blocks_dir . '/' . $block;
		if ( is_dir( $block_path ) && file_exists( $block_path . '/block.json' ) ) {
			register_block_type( $block_path );
		}
	}
}
add_action( 'init', 'sk_register_blocks' );
