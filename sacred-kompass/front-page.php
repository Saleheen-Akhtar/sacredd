<?php
/**
 * The front page template file
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

get_header();

// "Sacred Kompass Home" pre-composed layout
echo do_blocks('
<!-- wp:sk/hero-parallax /-->
<!-- wp:sk/character-reveal /-->
<!-- wp:sk/philosophy-strip /-->
<!-- wp:sk/values-pinned /-->
<!-- wp:sk/founders-stack /-->
<!-- wp:sk/offerings-grid /-->
<!-- wp:sk/quote-band /-->
<!-- wp:sk/stories-preview /-->
<!-- wp:sk/journal-grid /-->
<!-- wp:sk/events-upcoming /-->
<!-- wp:sk/faq-accordion /-->
<!-- wp:sk/newsletter-card /-->
<!-- wp:sk/cta-band /-->
');

get_footer();
