<?php
/**
 * Admin Options via Customizer
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function sk_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'sk_theme_options', [
		'title'       => __( 'Sacred Kompass Settings', 'sacred-kompass' ),
		'description' => __( 'Theme specific settings.', 'sacred-kompass' ),
		'priority'    => 160,
	] );

	// Hero Section
	$wp_customize->add_section( 'sk_hero_section', [
		'title' => __( 'Hero Section', 'sacred-kompass' ),
		'panel' => 'sk_theme_options',
	] );

	$hero_settings = [
		'hero_eyebrow'   => 'A Journey Inward',
		'hero_title'     => 'Find Your <em>Inner Compass</em>',
		'hero_subtitle'  => 'Ancient wisdom for the modern soul.',
		'hero_cta_label' => 'Begin the Journey',
		'hero_cta_url'   => '#offerings',
	];

	foreach ( $hero_settings as $key => $default ) {
		$wp_customize->add_setting( $key, [
			'default'           => $default,
			'sanitize_callback' => $key === 'hero_title' ? 'wp_kses_post' : 'sanitize_text_field',
		] );

		$wp_customize->add_control( $key, [
			'label'   => ucwords( str_replace( '_', ' ', $key ) ),
			'section' => 'sk_hero_section',
			'type'    => 'text',
		] );
	}

	// Newsletter Section
	$wp_customize->add_section( 'sk_newsletter_section', [
		'title' => __( 'Newsletter', 'sacred-kompass' ),
		'panel' => 'sk_theme_options',
	] );

	$newsletter_settings = [
		'newsletter_eyebrow'    => 'Stay Connected',
		'newsletter_heading'    => 'Join the <em>Inner Circle</em>',
		'newsletter_body'       => 'Gentle reminders of stillness...',
		'newsletter_form_id'    => '929',
		'newsletter_disclaimer' => 'Sacred Kompass respects your privacy.',
	];

	foreach ( $newsletter_settings as $key => $default ) {
		$wp_customize->add_setting( $key, [
			'default'           => $default,
			'sanitize_callback' => $key === 'newsletter_heading' ? 'wp_kses_post' : 'sanitize_text_field',
		] );

		$wp_customize->add_control( $key, [
			'label'   => ucwords( str_replace( '_', ' ', $key ) ),
			'section' => 'sk_newsletter_section',
			'type'    => 'text',
		] );
	}

    // Announcement Section
	$wp_customize->add_section( 'sk_announcement_section', [
		'title' => __( 'Announcement Bar', 'sacred-kompass' ),
		'panel' => 'sk_theme_options',
	] );

    $wp_customize->add_setting( 'announcement_text', [
        'default'           => 'Join our upcoming retreat in Sedona. Space is limited.',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'announcement_text', [
        'label'   => 'Announcement Text',
        'section' => 'sk_announcement_section',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'announcement_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ] );
    $wp_customize->add_control( 'announcement_url', [
        'label'   => 'Announcement URL',
        'section' => 'sk_announcement_section',
        'type'    => 'url',
    ] );
}
add_action( 'customize_register', 'sk_customize_register' );
