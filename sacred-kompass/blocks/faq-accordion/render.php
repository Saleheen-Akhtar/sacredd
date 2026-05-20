<?php
/**
 * FAQ Accordion Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$faqs = new WP_Query([
    'post_type'      => 'sk_faq',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
]);

if ( ! $faqs->have_posts() ) {
    return;
}
?>
<section class="sk-faq" data-faq-accordion>
    <div class="sk-faq__header">
        <h2 class="sk-faq__title" data-reveal>Frequently Asked Questions</h2>
    </div>

    <div class="sk-faq__list">
        <?php
        $stagger = 0;
        while ( $faqs->have_posts() ) : $faqs->the_post();
        ?>
            <div class="sk-faq__item" data-reveal data-stagger="<?php echo esc_attr($stagger); ?>">
                <button class="sk-faq__question" aria-expanded="false" aria-controls="faq-<?php the_ID(); ?>" data-faq-trigger>
                    <span class="sk-faq__question-text"><?php the_title(); ?></span>
                    <span class="sk-faq__icon" aria-hidden="true">
                        <span class="sk-faq__icon-v"></span>
                        <span class="sk-faq__icon-h"></span>
                    </span>
                </button>
                <div id="faq-<?php the_ID(); ?>" class="sk-faq__answer-wrapper" data-faq-content>
                    <div class="sk-faq__answer">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        <?php
        $stagger += 0.05;
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</section>
