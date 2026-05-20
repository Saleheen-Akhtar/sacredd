<?php
/**
 * Stories Preview Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$stories = new WP_Query([
    'post_type'      => 'sk_story',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC'
]);

if ( ! $stories->have_posts() ) {
    return;
}
?>
<section class="sk-stories-preview" id="stories">
    <div class="sk-stories-preview__header">
        <h2 class="sk-stories-preview__title" data-reveal>Stories & Wisdom</h2>
        <a href="<?php echo get_post_type_archive_link('sk_story'); ?>" class="sk-btn sk-btn--text" data-reveal data-stagger="0.1">View All Stories</a>
    </div>

    <div class="sk-stories-preview__grid">
        <?php
        $i = 0;
        while ( $stories->have_posts() ) : $stories->the_post();
            $is_featured = ($i === 0);
            $classes = 'sk-story-card ' . ($is_featured ? 'sk-story-card--featured' : 'sk-story-card--standard');
            $stagger = 0.2 + ($i * 0.1);
        ?>
            <article class="<?php echo esc_attr($classes); ?>" data-reveal data-stagger="<?php echo esc_attr($stagger); ?>">
                <a href="<?php get_permalink(); ?>" class="sk-story-card__link">
                    <div class="sk-story-card__image-wrapper">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( $is_featured ? 'large' : 'medium', ['class' => 'sk-story-card__image', 'data-parallax-img' => ''] ); ?>
                        <?php else: ?>
                            <div class="sk-story-card__image-placeholder"></div>
                        <?php endif; ?>
                    </div>
                    <div class="sk-story-card__content">
                        <time class="sk-story-card__date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <h3 class="sk-story-card__title"><?php the_title(); ?></h3>
                        <?php if ( $is_featured ) : ?>
                            <div class="sk-story-card__excerpt"><?php the_excerpt(); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            </article>
        <?php
        $i++;
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</section>
