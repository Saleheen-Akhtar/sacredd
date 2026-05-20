<?php
/**
 * Single template for standard posts
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

get_header();
?>
<article class="sk-single sk-single--post" style="background: var(--sk-cream); color: var(--sk-earth); min-height: 100vh;">
    <?php while ( have_posts() ) : the_post(); ?>

        <header class="sk-single__header" style="padding: calc(var(--sk-section-y) + 80px) var(--sk-section-x) var(--sk-space-xl); max-width: 900px; margin: 0 auto; text-align: center;">
            <time class="sk-single__date" style="font-family: var(--sk-font-eyebrow); font-size: var(--fs-eyebrow); color: var(--sk-gold); text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: var(--sk-space-md);" data-reveal><?php echo get_the_date(); ?></time>
            <h1 class="sk-single__title" style="font-family: var(--sk-font-display); font-size: var(--fs-h2); line-height: 1.1; margin-bottom: var(--sk-space-lg);" data-reveal data-stagger="0.1"><?php the_title(); ?></h1>
        </header>

        <div class="sk-single__content" style="max-width: 700px; margin: 0 auto; padding: 0 var(--sk-section-x) var(--sk-section-y); font-family: var(--sk-font-body); font-size: var(--fs-body); line-height: 1.8;" data-reveal>
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>
</article>
<?php
get_footer();
