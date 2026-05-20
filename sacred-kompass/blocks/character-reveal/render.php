<?php
/**
 * Character Reveal Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$text = $attributes['text'] ?? 'The wisdom you seek is already within you.';
?>
<section class="sk-character-reveal" data-character-reveal aria-label="Character Reveal">
    <div class="sk-character-reveal__content">
        <h2 class="sk-character-reveal__text">
            <?php
                $words = explode(' ', $text);
                foreach ($words as $word) {
                    echo '<span class="sk-character-reveal__word">';
                    $chars = mb_str_split($word);
                    foreach ($chars as $char) {
                        echo '<span class="sk-character-reveal__char">' . esc_html($char) . '</span>';
                    }
                    echo '</span> ';
                }
            ?>
        </h2>
    </div>
</section>
