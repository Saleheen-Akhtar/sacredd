<?php
/**
 * CTA Band Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$text         = $attributes['text']         ?? 'Ready to begin?';
$button_label = $attributes['button_label'] ?? 'Start Now';
$button_url   = $attributes['button_url']   ?? '#';
?>
<section class="sk-cta-band" data-reveal>
    <div class="sk-cta-band__inner">
        <h2 class="sk-cta-band__text"><?php echo esc_html($text); ?></h2>
        <a href="<?php echo esc_url($button_url); ?>" class="sk-btn sk-btn--gold">
            <?php echo esc_html($button_label); ?>
        </a>
    </div>
</section>
