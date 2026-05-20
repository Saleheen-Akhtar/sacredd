<?php
/**
 * Events Upcoming Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$events = new WP_Query([
    'post_type'      => 'sk_event',
    'posts_per_page' => 5,
    'meta_key'       => 'event_date', // Assuming standard meta key
    'orderby'        => 'meta_value',
    'order'          => 'ASC'
]);

// If no events, try fallback order by date
if ( ! $events->have_posts() ) {
    $events = new WP_Query([
        'post_type'      => 'sk_event',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);
}

if ( ! $events->have_posts() ) {
    return;
}
?>
<section class="sk-events-upcoming" data-events-upcoming>
    <div class="sk-events-upcoming__header">
        <h2 class="sk-events-upcoming__title" data-reveal>Gatherings</h2>
    </div>

    <div class="sk-events-upcoming__scroll-area">
        <div class="sk-events-upcoming__track" data-events-track>
            <?php
            $stagger = 0;
            while ( $events->have_posts() ) : $events->the_post();
                $date = get_post_meta(get_the_ID(), 'event_date', true) ?: get_the_date();
                $location = get_post_meta(get_the_ID(), 'event_location', true) ?: 'Virtual / TBD';
            ?>
                <article class="sk-event-card" data-reveal data-stagger="<?php echo esc_attr($stagger); ?>">
                    <div class="sk-event-card__inner">
                        <div class="sk-event-card__meta">
                            <span class="sk-event-card__date"><?php echo esc_html($date); ?></span>
                            <span class="sk-event-card__location"><?php echo esc_html($location); ?></span>
                        </div>
                        <h3 class="sk-event-card__title"><?php the_title(); ?></h3>
                        <div class="sk-event-card__excerpt"><?php the_excerpt(); ?></div>
                        <a href="<?php get_permalink(); ?>" class="sk-btn sk-btn--outline">View Details</a>
                    </div>
                </article>
            <?php
            $stagger += 0.1;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
