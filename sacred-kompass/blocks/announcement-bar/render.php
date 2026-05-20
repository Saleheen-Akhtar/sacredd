<?php
/**
 * Announcement Bar Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$text     = $attributes['text']     ?? sk_option('announcement_text', 'Join our upcoming retreat in Sedona. Space is limited.');
$link_url = $attributes['link_url'] ?? sk_option('announcement_url', '#');
?>
<div class="sk-announcement" data-announcement>
    <div class="sk-announcement__inner">
        <a href="<?php echo esc_url($link_url); ?>" class="sk-announcement__link">
            <?php echo esc_html($text); ?>
        </a>
        <button class="sk-announcement__close" aria-label="Dismiss announcement" data-announcement-close>
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>
