<?php
/**
 * Single template for Stories
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

get_header();
?>
<article class="sk-single sk-single--story" style="background: var(--sk-cream); color: var(--sk-earth); min-height: 100vh;">
    <?php while ( have_posts() ) : the_post(); ?>

        <header class="sk-single__header" style="padding: calc(var(--sk-section-y) + 80px) var(--sk-section-x) var(--sk-space-xl); max-width: 900px; margin: 0 auto; text-align: center;">
            <time class="sk-single__date" style="font-family: var(--sk-font-eyebrow); font-size: var(--fs-eyebrow); color: var(--sk-gold); text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: var(--sk-space-md);" data-reveal><?php echo get_the_date(); ?></time>
            <h1 class="sk-single__title" style="font-family: var(--sk-font-display); font-size: var(--fs-headline); line-height: 1.1; margin-bottom: var(--sk-space-lg);" data-reveal data-stagger="0.1"><?php the_title(); ?></h1>
            <div class="sk-single__meta" style="font-family: var(--sk-font-body); font-size: var(--fs-body); color: var(--sk-earth-60);" data-reveal data-stagger="0.2">
                By <?php the_author(); ?>
            </div>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="sk-single__featured-image" style="width: 100%; height: 60vh; overflow: hidden;" data-reveal>
                <?php the_post_thumbnail( 'full', ['style' => 'width: 100%; height: 100%; object-fit: cover;'] ); ?>
            </div>
        <?php endif; ?>

        <div class="sk-single__content" style="max-width: 700px; margin: 0 auto; padding: var(--sk-section-y) var(--sk-section-x); font-family: var(--sk-font-body); font-size: var(--fs-body); line-height: 1.8;" data-reveal>
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>
</article>

<?php echo do_blocks('<!-- wp:sk/newsletter-card /-->'); ?>

<?php
get_footer();
