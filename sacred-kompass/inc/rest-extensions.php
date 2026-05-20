<?php
/**
 * REST API Extensions
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_rest_prepare_post( $response, $post, $request ) {
	// Add featured image URL to REST response
	if ( has_post_thumbnail( $post->ID ) ) {
		$response->data['featured_image_url'] = get_the_post_thumbnail_url( $post->ID, 'large' );
	} else {
		$response->data['featured_image_url'] = null;
	}

	// Make sure all registered meta is exposed correctly
	$meta = get_post_meta( $post->ID );
	$response->data['custom_meta'] = $meta;

	return $response;
}

// Attach to all relevant CPTs
$cpts = ['post', 'sk_offering', 'sk_team', 'sk_story', 'sk_event', 'sk_faq', 'sk_value'];
foreach ( $cpts as $cpt ) {
	add_filter( "rest_prepare_{$cpt}", 'sk_rest_prepare_post', 10, 3 );
}
