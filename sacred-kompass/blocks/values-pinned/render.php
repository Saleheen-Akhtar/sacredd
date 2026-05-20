<?php
/**
 * Values Pinned Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$values = new WP_Query([
    'post_type'      => 'sk_value',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
]);

if ( ! $values->have_posts() ) {
    return;
}
?>
<section class="sk-values-pinned" data-values-pinned>
    <div class="sk-values-pinned__header">
        <h2 class="sk-values-pinned__title" data-reveal>Our Values</h2>
    </div>
    <div class="sk-values-pinned__scroll-container">
        <div class="sk-values-pinned__track" data-values-track>
            <?php while ( $values->have_posts() ) : $values->the_post(); ?>
                <div class="sk-values-pinned__card">
                    <h3 class="sk-values-pinned__card-title"><?php the_title(); ?></h3>
                    <div class="sk-values-pinned__card-text"><?php the_content(); ?></div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
