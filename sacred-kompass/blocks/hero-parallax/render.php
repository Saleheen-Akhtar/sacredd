<?php
/**
 * Hero Parallax Block — 6 layers + cinematic title
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$eyebrow  = $attributes['eyebrow']  ?? 'A Journey Inward';
$title    = $attributes['title']    ?? 'Find Your <em>Inner Compass</em>';
$subtitle = $attributes['subtitle'] ?? 'Ancient wisdom for the modern soul.';
$cta_label = $attributes['cta_label'] ?? 'Begin the Journey';
$cta_url   = $attributes['cta_url']   ?? '#offerings';

$layers = [
    ['slug' => 'sky',                'speed' => 0.05, 'depth' => -600, 'fade' => true],
    ['slug' => 'distant-mountains',  'speed' => 0.15, 'depth' => -450, 'fade' => false],
    ['slug' => 'mid-mountains',      'speed' => 0.30, 'depth' => -300, 'fade' => false],
    ['slug' => 'trees',              'speed' => 0.50, 'depth' => -150, 'fade' => false],
    ['slug' => 'foreground-foliage', 'speed' => 0.75, 'depth' => 0,    'fade' => false],
    ['slug' => 'foreground-rocks',   'speed' => 1.10, 'depth' => 80,   'fade' => false],
];
?>
<section class="sk-hero" data-sk-hero aria-label="<?php echo esc_attr(wp_strip_all_tags($title)); ?>">
    <div class="sk-hero__stage" data-stage>
        <?php foreach ($layers as $i => $layer) :
            $img = get_theme_file_uri("assets/images/hero-layers/layer-" . ($i + 1) . "-{$layer['slug']}.webp");
        ?>
        <div
            class="sk-hero__layer sk-hero__layer--<?php echo esc_attr($layer['slug']); ?>"
            data-layer
            data-speed="<?php echo esc_attr($layer['speed']); ?>"
            data-depth="<?php echo esc_attr($layer['depth']); ?>"
            data-fade="<?php echo $layer['fade'] ? 'true' : 'false'; ?>"
            style="--z: <?php echo esc_attr($layer['depth']); ?>px;"
        >
            <img src="<?php echo esc_url($img); ?>" alt="" role="presentation" loading="<?php echo $i < 2 ? 'eager' : 'lazy'; ?>" decoding="async" fetchpriority="<?php echo $i < 3 ? 'high' : 'auto'; ?>" />
        </div>
        <?php endforeach; ?>

        <div class="sk-hero__content" data-layer data-speed="0.20" data-fade="true">
            <p class="sk-hero__eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h1 class="sk-hero__title" data-cr-text>
                <?php echo wp_kses($title, ['em' => [], 'span' => ['class' => true]]); ?>
            </h1>
            <p class="sk-hero__subtitle"><?php echo esc_html($subtitle); ?></p>
            <a class="sk-btn sk-btn--terra" href="<?php echo esc_url($cta_url); ?>">
                <?php echo esc_html($cta_label); ?>
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>
