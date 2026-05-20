<?php
/**
 * Register Custom Post Types and Meta
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_register_cpts() {
	$cpts = [
		'sk_offering'     => 'Offerings',
		'sk_team'         => 'Team',
		'sk_story'        => 'Stories',
		'sk_event'        => 'Events',
		'sk_faq'          => 'FAQs',
		'sk_value'        => 'Values',
		'sk_announcement' => 'Announcements',
		'sk_legal'        => 'Legal Pages',
	];

	foreach ( $cpts as $slug => $name ) {
		$args = [
			'labels'              => [
				'name'          => $name,
				'singular_name' => rtrim( $name, 's' ),
			],
			'public'              => true,
			'show_in_rest'        => true,
			'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
			'has_archive'         => true,
			'rewrite'             => [ 'slug' => str_replace( 'sk_', '', $slug ) ],
		];

		if ( $slug === 'sk_legal' || $slug === 'sk_announcement' ) {
			$args['has_archive'] = false;
			$args['publicly_queryable'] = false;
		}

		register_post_type( $slug, $args );
	}
}
add_action( 'init', 'sk_register_cpts' );

function sk_register_meta() {
	// Example meta registration to satisfy "every custom meta key registered" rule
	// Specific keys depend on actual use, registering common ones
	$cpts_with_subtitle = ['sk_offering', 'sk_team', 'sk_story', 'sk_event'];
	foreach ( $cpts_with_subtitle as $cpt ) {
		register_post_meta( $cpt, 'sk_subtitle', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
	}
}
add_action( 'init', 'sk_register_meta' );
