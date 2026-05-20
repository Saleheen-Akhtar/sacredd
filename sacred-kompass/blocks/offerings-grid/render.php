<?php
/**
 * Offerings Grid Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$offerings = new WP_Query([
    'post_type'      => 'sk_offering',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
]);

if ( ! $offerings->have_posts() ) {
    return;
}
?>
<section class="sk-offerings-grid" id="offerings">
    <div class="sk-offerings-grid__header">
        <h2 class="sk-offerings-grid__title" data-reveal>Our Offerings</h2>
    </div>

    <div class="sk-offerings-grid__grid">
        <?php $stagger = 0; while ( $offerings->have_posts() ) : $offerings->the_post(); ?>
            <div class="sk-offerings-grid__item" data-reveal data-stagger="<?php echo esc_attr( $stagger ); ?>">
                <div class="sk-offerings-grid__item-inner">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="sk-offerings-grid__image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="sk-offerings-grid__content">
                        <h3 class="sk-offerings-grid__item-title"><?php the_title(); ?></h3>
                        <div class="sk-offerings-grid__item-excerpt"><?php the_excerpt(); ?></div>
                        <button class="sk-btn sk-btn--text" data-modal-trigger="<?php echo get_the_ID(); ?>">Explore</button>
                    </div>
                </div>
            </div>
            <?php $stagger += 0.1; ?>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>
