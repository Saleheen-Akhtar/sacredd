<?php
/**
 * Founders Stack Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$team = new WP_Query([
    'post_type'      => 'sk_team',
    'posts_per_page' => 5,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
]);

if ( ! $team->have_posts() ) {
    return;
}

$founders_data = [];
while ( $team->have_posts() ) {
    $team->the_post();
    $founders_data[] = [
        'title' => get_the_title(),
        'role'  => get_post_meta( get_the_ID(), 'sk_subtitle', true ),
        'image' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
        'bio'   => get_the_excerpt()
    ];
}
wp_reset_postdata();
?>
<section class="sk-founders-stack" data-reveal>
    <div class="sk-founders-stack__header">
        <h2 class="sk-founders-stack__title">The Guides</h2>
    </div>

    <sk-founders-stack .founders='<?php echo esc_attr( wp_json_encode( $founders_data ) ); ?>'></sk-founders-stack>
</section>
