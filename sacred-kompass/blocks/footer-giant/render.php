<?php
/**
 * Footer Giant Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
?>
<section class="sk-footer-giant" data-footer-giant>
    <div class="sk-footer-giant__content">
        <div class="sk-footer-giant__links">
            <!-- Example Links -->
            <a href="#offerings">Offerings</a>
            <a href="#about">About</a>
            <a href="#journal">Journal</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="sk-footer-giant__legal">
            <p>&copy; <?php echo date('Y'); ?> Sacred Kompass. All rights reserved.</p>
        </div>
    </div>

    <div class="sk-footer-giant__logo-wrapper" aria-hidden="true" data-footer-logo>
        <!-- Placeholder for actual SVG -->
        <svg viewBox="0 0 800 200" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
            <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" font-family="var(--sk-font-display)" font-size="120" fill="currentColor">
                SACRED KOMPASS
            </text>
        </svg>
    </div>
</section>
