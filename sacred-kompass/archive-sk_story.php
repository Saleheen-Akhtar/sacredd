<?php
/**
 * Archive template for Stories
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

get_header();
?>
<div class="sk-archive sk-archive--stories" style="padding: calc(var(--sk-section-y) + 80px) var(--sk-section-x) var(--sk-section-y); background: var(--sk-cream); color: var(--sk-earth); min-height: 100vh;">
    <header class="sk-archive__header" style="margin-bottom: var(--sk-space-xl);">
        <h1 class="sk-archive__title" style="font-family: var(--sk-font-display); font-size: var(--fs-h2);" data-reveal>Stories & Wisdom</h1>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="sk-archive__grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--sk-space-lg);">
            <?php
            $stagger = 0;
            while ( have_posts() ) : the_post();
            ?>
                <article class="sk-story-card sk-story-card--standard" data-reveal data-stagger="<?php echo esc_attr($stagger); ?>" style="display: block;">
                    <a href="<?php get_permalink(); ?>" class="sk-story-card__link" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; gap: var(--sk-space-md);">
                        <div class="sk-story-card__image-wrapper" style="overflow: hidden; position: relative; aspect-ratio: 4/3;">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', ['class' => 'sk-story-card__image', 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform var(--dur-slow) var(--ease-out);'] ); ?>
                            <?php else: ?>
                                <div class="sk-story-card__image-placeholder" style="width: 100%; height: 100%; background: var(--sk-earth-12);"></div>
                            <?php endif; ?>
                        </div>
                        <div class="sk-story-card__content">
                            <time class="sk-story-card__date" style="font-family: var(--sk-font-eyebrow); font-size: var(--fs-eyebrow); color: var(--sk-earth-60); text-transform: uppercase; letter-spacing: 0.1em;"><?php echo get_the_date(); ?></time>
                            <h3 class="sk-story-card__title" style="font-family: var(--sk-font-display); font-size: var(--fs-h3); margin: var(--sk-space-2xs) 0 0 0;"><?php the_title(); ?></h3>
                        </div>
                    </a>
                </article>
            <?php
            $stagger += 0.1;
            endwhile;
            ?>
        </div>
        <div class="sk-pagination" style="margin-top: var(--sk-space-xl); display: flex; justify-content: space-between;">
            <?php previous_posts_link( '← Newer Stories' ); ?>
            <?php next_posts_link( 'Older Stories →' ); ?>
        </div>
    <?php else : ?>
        <p>No stories found.</p>
    <?php endif; ?>
</div>
<?php
get_footer();
