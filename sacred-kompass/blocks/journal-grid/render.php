<?php
/**
 * Journal Grid Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$posts = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC'
]);

if ( ! $posts->have_posts() ) {
    return;
}
?>
<section class="sk-journal-grid" id="journal">
    <div class="sk-journal-grid__header">
        <h2 class="sk-journal-grid__title" data-reveal>Journal</h2>
    </div>

    <div class="sk-journal-grid__masonry" data-journal-masonry>
        <?php
        $stagger = 0;
        while ( $posts->have_posts() ) : $posts->the_post();
        ?>
            <article class="sk-journal-card" data-reveal data-stagger="<?php echo esc_attr($stagger); ?>">
                <a href="<?php get_permalink(); ?>" class="sk-journal-card__link">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="sk-journal-card__image-wrapper">
                            <?php the_post_thumbnail('medium_large', ['class' => 'sk-journal-card__image']); ?>
                            <div class="sk-journal-card__overlay">
                                <span class="sk-journal-card__read">Read Article</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="sk-journal-card__content">
                        <time class="sk-journal-card__date"><?php echo get_the_date(); ?></time>
                        <h3 class="sk-journal-card__title"><?php the_title(); ?></h3>
                    </div>
                </a>
            </article>
        <?php
        $stagger += 0.1;
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</section>
