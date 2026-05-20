<?php
/**
 * Philosophy Strip Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$text = $attributes['text'] ?? sk_option('philosophy_text', 'Stillness is not an absence, but a profound presence.');
?>
<section class="sk-philosophy-strip" data-philosophy-strip>
    <div class="sk-philosophy-strip__inner" data-strip-inner>
        <h2 class="sk-philosophy-strip__text"><?php echo esc_html($text); ?></h2>
    </div>
</section>
