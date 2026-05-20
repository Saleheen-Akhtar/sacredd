<?php
/**
 * The template for displaying 404 pages (not found)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

get_header();
?>
<main id="primary" class="site-main" style="background: var(--sk-earth); color: var(--sk-cream); min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center;">
    <section class="error-404 not-found" style="padding: var(--sk-section-x);">
        <!-- Character reveal style treatment for "Lost" -->
        <h1 class="page-title" style="font-family: var(--sk-font-display); font-size: var(--fs-display); color: var(--sk-sage); line-height: 1;" data-reveal>Lost</h1>
        <div class="page-content" data-reveal data-stagger="0.2">
            <p style="font-family: var(--sk-font-body); font-size: var(--fs-body); margin: var(--sk-space-md) 0 var(--sk-space-xl); color: var(--sk-cream-30);">The path you are looking for has faded into the mist.</p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sk-btn sk-btn--gold">Return Home</a>
        </div>
    </section>
</main>
<?php
get_footer();
