<?php
/**
 * Quote Band Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$quote  = $attributes['quote']  ?? sk_option('quote_text', 'The journey of a thousand miles begins with a single step.');
$author = $attributes['author'] ?? sk_option('quote_author', 'Lao Tzu');
// Fallback image handling
$bg_url = sk_image('layer-4-trees.webp'); // Default to one of the hero layers for demo
?>
<section class="sk-quote-band" data-quote-band>
    <div class="sk-quote-band__bg-wrapper">
        <div class="sk-quote-band__bg" data-parallax-bg style="background-image: url('<?php echo esc_url($bg_url); ?>');"></div>
        <div class="sk-quote-band__overlay"></div>
    </div>

    <div class="sk-quote-band__content">
        <blockquote class="sk-quote-band__blockquote">
            <p class="sk-quote-band__text" data-quote-text>
                <?php
                    // Simple character wrap for char-reveal
                    $words = explode(' ', $quote);
                    foreach ($words as $word) {
                        echo '<span class="sk-quote-word">';
                        $chars = mb_str_split($word);
                        foreach ($chars as $char) {
                            echo '<span class="sk-quote-char">' . esc_html($char) . '</span>';
                        }
                        echo '</span> ';
                    }
                ?>
            </p>
            <footer class="sk-quote-band__author" data-reveal data-stagger="0.5">
                — <?php echo esc_html($author); ?>
            </footer>
        </blockquote>
    </div>
</section>
