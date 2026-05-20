<?php
/**
 * The header for our theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php echo do_blocks('<!-- wp:sk/announcement-bar /-->'); ?>

<header class="sk-header">
    <div class="sk-header__inner" style="padding: var(--sk-space-md) var(--sk-section-x); display: flex; justify-content: space-between; align-items: center; position: absolute; width: 100%; z-index: var(--z-nav);">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="color: var(--sk-cream); text-decoration: none; font-family: var(--sk-font-eyebrow); letter-spacing: 0.1em; text-transform: uppercase;">
            Sacred Kompass
        </a>
        <button class="sk-header__menu-toggle" aria-label="Open menu" style="background: none; border: none; color: var(--sk-cream); font-family: var(--sk-font-eyebrow); letter-spacing: 0.1em; text-transform: uppercase; cursor: pointer;" onclick="document.querySelector('sk-menu-overlay').toggleMenu()">
            Menu
        </button>
    </div>
</header>
<sk-menu-overlay></sk-menu-overlay>
<main id="main" class="site-main">
