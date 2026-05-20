<?php
/**
 * Newsletter Card Block — Single source of truth
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$eyebrow    = sk_option('newsletter_eyebrow',    'Stay Connected');
$heading    = sk_option('newsletter_heading',    'Join the <em>Inner Circle</em>');
$body       = sk_option('newsletter_body',       'Gentle reminders of stillness...');
$form_id    = sk_option('newsletter_form_id',    929);
$disclaimer = sk_option('newsletter_disclaimer', 'Sacred Kompass respects your privacy.');
?>
<section class="sk-newsletter" aria-labelledby="sk-newsletter-heading" data-reveal>
    <div class="sk-newsletter__inner">
        <p class="sk-newsletter__eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <h2 id="sk-newsletter-heading" class="sk-newsletter__heading">
            <?php echo wp_kses($heading, ['em' => []]); ?>
        </h2>
        <p class="sk-newsletter__body"><?php echo esc_html($body); ?></p>

        <div class="sk-newsletter__form">
            <?php
            if ( shortcode_exists( 'forminator_form' ) ) {
                echo do_shortcode( sprintf( '[forminator_form id="%d"]', (int) $form_id ) );
            } else {
                echo '<p>Forminator form goes here (ID: ' . esc_html($form_id) . ')</p>';
            }
            ?>
        </div>

        <p class="sk-newsletter__disclaimer"><?php echo esc_html($disclaimer); ?></p>
    </div>
</section>
