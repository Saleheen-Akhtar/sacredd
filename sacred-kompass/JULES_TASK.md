# TASK: Rebuild sacredkompass.org from scratch as a modern, animation-first WordPress theme

You are building **Sacred Kompass v10** — a complete rewrite of an existing WordPress theme. The goal is to match the cinematic quality of **ironhill.au** (Awwwards SOTD-grade animation, scroll choreography, and design discipline) while keeping it 100% WordPress-native and editor-friendly via Gutenberg blocks.

Do NOT port the old `fixed_v3` codebase. Start clean. The old theme had a 2,021-line legacy.css, broken `d1/d2/d3/d4` stagger classes, and a newsletter block duplicated across 3 PHP files. We are throwing all of that away.

---

## §0 KICKOFF PROMPT (read this first, then produce a plan)

Before writing any code, produce a **PLAN** with:
1. The exact file tree you will create (see §3 for the required skeleton).
2. The order of phases (must follow §6 — Phase 1 → 5).
3. A list of npm dependencies you will install with exact versions.
4. The 3 acceptance tests you will run after each phase (see §7).

Wait for me to approve the plan before generating any files.

---

## §1 BRAND IDENTITY (NON-NEGOTIABLE)

### Color Palette — ONLY these 5 colors + their alphas. No others.
```css
--sk-cream:    #FAF6EE;   /* page background, body text on dark */
--sk-earth:    #2B2017;   /* primary text, dark sections */
--sk-terra:    #C56A3F;   /* primary CTA, accents */
--sk-gold:     #D4A24C;   /* secondary accent, focus rings, eyebrow text */
--sk-sage:     #9DA888;   /* ghost-text layer for character-reveal, muted */

/* Derived alphas — generate only these, no inline rgba() elsewhere */
--sk-earth-60: rgba(43, 32, 23, 0.6);
--sk-earth-12: rgba(43, 32, 23, 0.12);
--sk-cream-30: rgba(250, 246, 238, 0.3);
--sk-gold-20:  rgba(212, 162, 76, 0.2);
--sk-terra-50: rgba(197, 106, 63, 0.5);
Copy
Any hardcoded hex value outside theme.json and tokens.css must fail the build (add a stylelint rule).

Typography — 2 families, weight-restricted
Copy--sk-font-display: 'Cormorant Garamond', 'Cormorant', Georgia, serif;  /* 400, 500 */
--sk-font-body:    'Inter', system-ui, -apple-system, sans-serif;       /* 400, 500, 600 */
--sk-font-eyebrow: 'Inter', sans-serif;  /* 500, uppercase, letter-spacing .12em */
Load via @font-face with font-display: block (cinematic — preloader masks the wait). Self-host woff2 files in /assets/fonts/. No Google Fonts CDN.

Type scale — Use min(Nvw, Mvh) for headlines (the ironhill secret)
Copy--fs-eyebrow:  12px;                          /* uppercase labels */
--fs-body-sm:  clamp(14px, min(0.81vw, 2.18vh), 16px);
--fs-body:     clamp(16px, min(1.1vw, 2.9vh), 20px);
--fs-h3:       clamp(2rem, 3.75vw, 3.4rem);
--fs-h2:       clamp(2.5rem, min(5.5vw, 13vh), 5rem);
--fs-headline: min(6.5vw, 17.5vh);            /* hero title — NEVER overflows viewport */
--fs-display:  min(11.8vw, 31.8vh);           /* preloader, 404 */
Spacing — Fluid tokens, no raw px in section files
Copy--sk-space-3xs: 4px;
--sk-space-2xs: 8px;
--sk-space-xs:  12px;
--sk-space-sm:  16px;
--sk-space-md:  24px;
--sk-space-lg:  40px;
--sk-space-xl:  64px;
--sk-space-2xl: 96px;
--sk-section-y: clamp(80px, 12vh, 160px);     /* vertical section padding */
--sk-section-x: clamp(20px, 5vw, 80px);       /* horizontal gutter */
Easing — ONLY these. Lint everything else away.
Copy--ease-out:    cubic-bezier(0.22, 1, 0.36, 1);   /* power2.out equivalent */
--ease-hero:   cubic-bezier(0.16, 1, 0.3, 1);    /* power3.out equivalent */
Copy// In JS, only these two:
export const EASE = { out: 'power2.out', hero: 'power3.out' };
export const DUR  = { fast: 0.4, base: 0.8, slow: 1.2 };
Z-index ladder
Copy--z-base:         1;
--z-content:      10;
--z-sticky:       100;
--z-nav:          1000;
--z-modal:        9000;
--z-overlay:      9500;
--z-announcement: 9800;
--z-preloader:    9900;
--z-curtain:      9999;   /* route transition */
§2 TECH STACK (exact versions — install these)
Copy{
  "name": "sacred-kompass",
  "version": "10.0.0",
  "type": "module",
  "scripts": {
    "dev":   "vite",
    "build": "vite build && wp-scripts build",
    "lint":  "stylelint 'assets/css/**/*.css' && eslint 'src/**/*.{js,ts}'"
  },
  "devDependencies": {
    "@wordpress/scripts":     "^27.9.0",
    "@wordpress/blocks":      "^13.0.0",
    "@wordpress/block-editor":"^14.0.0",
    "@wordpress/components":  "^28.0.0",
    "@wordpress/i18n":         "^5.0.0",
    "vite":                    "^5.4.0",
    "typescript":              "^5.4.0",
    "stylelint":               "^16.0.0",
    "stylelint-config-standard":"^36.0.0",
    "eslint":                  "^9.0.0"
  },
  "dependencies": {
    "gsap":  "^3.12.5",
    "lenis": "^1.1.13",
    "lit":   "^3.1.0"
  }
}
Why this stack:

GSAP + ScrollTrigger — animation engine (ScrollTrigger ships free with GSAP 3.12+)
Lenis — free ScrollSmoother replacement (95% equivalent, 5KB gzipped)
Lit — for interactive web-component islands inside Gutenberg blocks (lighter than Vue/React)
Vite — front-end bundler for view.js files
@wordpress/scripts — Gutenberg block editor builds
Do NOT add: Three.js (defer to v10.1), jQuery, Bootstrap, Tailwind, any animation lib other than GSAP.

§3 REQUIRED FILE TREE
Create this exact structure:

Copysacred-kompass/
├─ AGENTS.md                          ← describes the theme for Jules itself
├─ JULES_TASK.md                      ← this file
├─ style.css                          ← WP theme header ONLY (~30 lines)
├─ theme.json                         ← FSE tokens (palette, fonts, spacing)
├─ functions.php                      ← THIN: enqueue + load /inc
├─ index.php                          ← fallback (just calls block template)
├─ front-page.php                     ← renders the home block composition
├─ single.php                         ← single post template
├─ single-sk_story.php
├─ archive-sk_story.php
├─ header.php
├─ footer.php
├─ 404.php
├─ inc/
│  ├─ enqueue.php                    ← all wp_enqueue_* calls (versioned)
│  ├─ cpt-register.php               ← 8 CPTs with show_in_rest + register_post_meta
│  ├─ blocks-register.php            ← register_block_type() loop over /blocks/*
│  ├─ image-sizes.php                ← add_image_size for hero layers, cards
│  ├─ rest-extensions.php            ← custom REST fields
│  ├─ admin-options.php              ← Settings → Sacred Kompass page (Customizer API)
│  └─ helpers.php                    ← sk_option(), sk_render_block(), sk_image()
├─ blocks/                            ← ⭐ ONE block per section
│  ├─ hero-parallax/                  ← §4 — the 6-layer parallax hero
│  │  ├─ block.json
│  │  ├─ render.php
│  │  ├─ edit.jsx
│  │  ├─ view.ts
│  │  └─ style.css
│  ├─ character-reveal/               ← scroll-scrubbed letter color reveal
│  ├─ values-pinned/                  ← horizontal pinned scroll values
│  ├─ founders-stack/                 ← fanned-deck card stack
│  ├─ offerings-grid/
│  ├─ philosophy-strip/
│  ├─ quote-band/
│  ├─ stories-preview/
│  ├─ journal-grid/
│  ├─ events-upcoming/                ← NEW: backed by sk_event CPT
│  ├─ faq-accordion/
│  ├─ newsletter-card/                ← single source of truth (kills 3× duplicate)
│  ├─ cta-band/
│  └─ footer-giant/
├─ assets/
│  ├─ css/
│  │  ├─ tokens.css                   ← :root tokens from §1
│  │  ├─ reset.css                    ← modern CSS reset
│  │  ├─ base.css                     ← html/body, typography defaults
│  │  ├─ layout.css                   ← container, grid utilities
│  │  ├─ motion.css                   ← reveal initial states (opacity:0, translateY)
│  │  └─ utilities.css                ← .visually-hidden, .no-scroll, etc.
│  ├─ fonts/
│  │  ├─ CormorantGaramond-Regular.woff2
│  │  ├─ CormorantGaramond-Medium.woff2
│  │  ├─ Inter-Regular.woff2
│  │  ├─ Inter-Medium.woff2
│  │  └─ Inter-SemiBold.woff2
│  └─ images/hero-layers/
│     ├─ layer-1-sky.webp            ← farthest (background)
│     ├─ layer-2-distant-mountains.webp
│     ├─ layer-3-mid-mountains.webp
│     ├─ layer-4-trees.webp
│     ├─ layer-5-foreground-foliage.webp
│     └─ layer-6-foreground-rocks.webp  ← closest (foreground)
├─ src/
│  ├─ main.ts                         ← entry: boots Lenis, GSAP, mounts blocks
│  ├─ lib/
│  │  ├─ motion.ts                    ← single motion config (EASE, DUR, helpers)
│  │  ├─ smooth-scroll.ts             ← Lenis wrapper + ScrollTrigger sync
│  │  ├─ reveal.ts                    ← [data-reveal] system (kills d1/d2/d3/d4)
│  │  ├─ character-reveal.ts          ← per-char scroll-scrub
│  │  ├─ parallax.ts                  ← §4 hero parallax controller
│  │  ├─ cursor.ts                    ← custom cursor (optional, off by default)
│  │  └─ preloader.ts                 ← odometer-style 0→100% loader
│  └─ components/                     ← Lit web components for blocks
│     ├─ sk-menu-overlay.ts
│     ├─ sk-founders-stack.ts
│     └─ sk-stories-marquee.ts
├─ vite.config.ts
├─ tsconfig.json
├─ .stylelintrc.json                  ← enforce no raw hex, no raw cubic-bezier
└─ package.json
§4 ⭐ HERO SECTION — 6-LAYER PARALLAX (HIGHEST PRIORITY)
This is the centerpiece. Replicate ironhill's cinematic feel using 6 PNG/WebP layers that move at different scroll speeds. The user will provide the 6 images; create placeholders matching these exact slots:

Layer	Filename	Z-order	Parallax speed	Opacity behavior	Z-axis (CSS)
Layer 1	layer-1-sky.webp	back	0.05× (slow)	fades to 0.7 on scroll	translateZ(-600px)
Layer 2	layer-2-distant-mountains.webp	back-mid	0.15×	stays 100%	translateZ(-450px)
Layer 3	layer-3-mid-mountains.webp	mid	0.30×	stays 100%	translateZ(-300px)
Layer 4	layer-4-trees.webp	mid-fore	0.50×	stays 100%	translateZ(-150px)
Layer 5	layer-5-foreground-foliage.webp	fore	0.75×	stays 100%	translateZ(0)
Layer 6	layer-6-foreground-rocks.webp	front	1.10× (fastest)	stays 100%	translateZ(80px)
Text	hero headline + CTA	top	0.20×	fades out @ 60% scroll	translateZ(40px)
blocks/hero-parallax/render.php
Copy<?php
/**
 * Hero Parallax Block — 6 layers + cinematic title
 * Editable attributes: eyebrow, title (with <em> support), subtitle, cta_label, cta_url, layer_overrides
 */
defined('ABSPATH') || exit;

$eyebrow  = $attributes['eyebrow']  ?? sk_option('hero_eyebrow',  'A Journey Inward');
$title    = $attributes['title']    ?? sk_option('hero_title',    'Find Your <em>Inner Compass</em>');
$subtitle = $attributes['subtitle'] ?? sk_option('hero_subtitle', 'Ancient wisdom for the modern soul.');
$cta_label = $attributes['cta_label'] ?? sk_option('hero_cta_label', 'Begin the Journey');
$cta_url   = $attributes['cta_url']   ?? sk_option('hero_cta_url', '#offerings');

$layers = [
    ['slug' => 'sky',                'speed' => 0.05, 'depth' => -600, 'fade' => true],
    ['slug' => 'distant-mountains',  'speed' => 0.15, 'depth' => -450, 'fade' => false],
    ['slug' => 'mid-mountains',      'speed' => 0.30, 'depth' => -300, 'fade' => false],
    ['slug' => 'trees',              'speed' => 0.50, 'depth' => -150, 'fade' => false],
    ['slug' => 'foreground-foliage', 'speed' => 0.75, 'depth' => 0,    'fade' => false],
    ['slug' => 'foreground-rocks',   'speed' => 1.10, 'depth' => 80,   'fade' => false],
];
?>
<section
    class="sk-hero"
    data-sk-hero
    aria-label="<?php echo esc_attr(wp_strip_all_tags($title)); ?>"
>
    <div class="sk-hero__stage" data-stage>
        <?php foreach ($layers as $i => $layer) :
            $img = sk_image("hero-layers/layer-" . ($i + 1) . "-{$layer['slug']}.webp");
        ?>
        <div
            class="sk-hero__layer sk-hero__layer--<?php echo esc_attr($layer['slug']); ?>"
            data-layer
            data-speed="<?php echo esc_attr($layer['speed']); ?>"
            data-depth="<?php echo esc_attr($layer['depth']); ?>"
            data-fade="<?php echo $layer['fade'] ? 'true' : 'false'; ?>"
            style="--z: <?php echo esc_attr($layer['depth']); ?>px;"
        >
            <img
                src="<?php echo esc_url($img); ?>"
                alt=""
                role="presentation"
                loading="<?php echo $i < 2 ? 'eager' : 'lazy'; ?>"
                decoding="async"
                fetchpriority="<?php echo $i < 3 ? 'high' : 'auto'; ?>"
            />
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

    <div class="sk-hero__scroll-hint" aria-hidden="true">
        <span>Scroll</span>
        <svg viewBox="0 0 24 40" width="20" height="34"><!-- mouse SVG --></svg>
    </div>
</section>
Copy
blocks/hero-parallax/style.css
Copy@layer components {
  .sk-hero {
    position: relative;
    height: 100vh;
    height: 100svh;
    min-height: 600px;
    overflow: hidden;
    background: var(--sk-earth);
    isolation: isolate;
  }

  .sk-hero__stage {
    position: absolute;
    inset: 0;
    perspective: 1500px;
    transform-style: preserve-3d;
    will-change: transform;
  }

  .sk-hero__layer {
    position: absolute;
    inset: -10% -5%;  /* oversize so parallax never reveals edges */
    transform: translate3d(0, 0, var(--z, 0px));
    transform-style: preserve-3d;
    will-change: transform, opacity;
    pointer-events: none;
  }

  .sk-hero__layer img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center bottom;
    display: block;
  }

  /* Each layer can have specific tuning */
  .sk-hero__layer--sky               { z-index: 1; }
  .sk-hero__layer--distant-mountains { z-index: 2; }
  .sk-hero__layer--mid-mountains     { z-index: 3; }
  .sk-hero__layer--trees             { z-index: 4; }
  .sk-hero__layer--foreground-foliage{ z-index: 5; }
  .sk-hero__layer--foreground-rocks  { z-index: 6; }

  .sk-hero__content {
    position: relative;
    z-index: 10;
    display: grid;
    place-content: center;
    text-align: center;
    height: 100%;
    padding: 0 var(--sk-section-x);
    color: var(--sk-cream);
    pointer-events: auto;
  }

  .sk-hero__eyebrow {
    font-family: var(--sk-font-eyebrow);
    font-size: var(--fs-eyebrow);
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--sk-gold);
    margin: 0 0 var(--sk-space-md);
  }

  .sk-hero__title {
    font-family: var(--sk-font-display);
    font-size: var(--fs-headline);
    font-weight: 400;
    line-height: 1.02;
    margin: 0 0 var(--sk-space-md);
    max-width: 14ch;
    margin-inline: auto;
  }
  .sk-hero__title em {
    font-style: italic;
    color: var(--sk-gold);
  }

  .sk-hero__subtitle {
    font-family: var(--sk-font-body);
    font-size: var(--fs-body);
    color: var(--sk-cream-30);
    color: color-mix(in oklab, var(--sk-cream) 80%, transparent);
    max-width: 48ch;
    margin: 0 auto var(--sk-space-xl);
  }

  .sk-hero__scroll-hint {
    position: absolute;
    bottom: var(--sk-space-lg);
    left: 50%;
    transform: translateX(-50%);
    z-index: 11;
    color: var(--sk-cream);
    opacity: 0.6;
    animation: sk-bob 2.4s var(--ease-out) infinite;
  }
  @keyframes sk-bob {
    0%, 100% { transform: translate(-50%, 0); }
    50%      { transform: translate(-50%, 8px); }
  }

  /* Reduced motion */
  @media (prefers-reduced-motion: reduce) {
    .sk-hero__layer { transform: none !important; }
    .sk-hero__scroll-hint { animation: none; }
  }
}
Copy
src/lib/parallax.ts — the engine
Copyimport { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);

export interface HeroParallaxConfig {
  /** Multiplier for vertical drift in viewport heights. 1 = full vh of drift. */
  driftScale?: number;
  /** Enable mouse-tilt micro-interaction on the hero. */
  mouseTilt?: boolean;
}

export function initHeroParallax(
  root: HTMLElement,
  cfg: HeroParallaxConfig = {}
): () => void {
  const { driftScale = 1, mouseTilt = true } = cfg;
  const layers = Array.from(root.querySelectorAll<HTMLElement>('[data-layer]'));
  if (!layers.length) return () => {};

  // Respect reduced motion
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return () => {};
  }

  // 1) SCROLL-LINKED VERTICAL PARALLAX
  const triggers: ScrollTrigger[] = [];
  layers.forEach((layer) => {
    const speed = parseFloat(layer.dataset.speed ?? '0.3');
    const fade  = layer.dataset.fade === 'true';
    const drift = window.innerHeight * driftScale * speed;

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: root,
        start: 'top top',
        end:   'bottom top',
        scrub: 0.8,  // smooth catch-up; not 0 (jittery) not too high (laggy)
      },
    });
    tl.to(layer, { y: -drift, ease: 'none' }, 0);
    if (fade) tl.to(layer, { opacity: 0.0, ease: 'none' }, 0);

    if (tl.scrollTrigger) triggers.push(tl.scrollTrigger);
  });

  // 2) MOUSE-TILT (subtle, only on pointer:fine devices)
  let mouseHandler: ((e: PointerEvent) => void) | null = null;
  if (mouseTilt && window.matchMedia('(pointer: fine)').matches) {
    const stage = root.querySelector<HTMLElement>('[data-stage]');
    if (stage) {
      const tiltAmt = layers.map((_, i) => (i + 1) * 4); // 4px..28px range
      mouseHandler = (e: PointerEvent) => {
        const rect = root.getBoundingClientRect();
        const cx = (e.clientX - rect.left) / rect.width  - 0.5; // -0.5..0.5
        const cy = (e.clientY - rect.top)  / rect.height - 0.5;
        layers.forEach((layer, i) => {
          gsap.to(layer, {
            x: cx * tiltAmt[i] * -1,
            // additive Y - GSAP merges with scroll Y via separate tween scopes
            duration: 0.8,
            ease: 'power2.out',
            overwrite: 'auto',
          });
        });
      };
      root.addEventListener('pointermove', mouseHandler, { passive: true });
    }
  }

  // 3) INITIAL ENTRY — hero content fades up after load
  const content = root.querySelector<HTMLElement>('.sk-hero__content');
  if (content) {
    gsap.from(content.children, {
      y: 40,
      opacity: 0,
      duration: 1.2,
      ease: 'power3.out',
      stagger: 0.12,
      delay: 0.2,
    });
  }

  // Cleanup
  return () => {
    triggers.forEach(t => t.kill());
    if (mouseHandler) root.removeEventListener('pointermove', mouseHandler);
  };
}
Copy
blocks/hero-parallax/view.ts
Copyimport { initHeroParallax } from '@/lib/parallax';

document.querySelectorAll<HTMLElement>('[data-sk-hero]').forEach((root) => {
  initHeroParallax(root, { driftScale: 1, mouseTilt: true });
});
Hero acceptance criteria:

On scroll, the 6 layers drift at visibly different speeds (back = slow, front = fast).
The sky layer fades to ~0 by the time the hero leaves the viewport.
On pointermove, layers shift horizontally by 4-28px (back to front).
Text content enters with a staggered fade-up on load.
prefers-reduced-motion: reduce disables all parallax and tilt — layers stay static.
No layout shift (CLS = 0). Images have width/height attributes.
First Contentful Paint < 1.5s on 4G Fast (Lighthouse).
§5 SECTIONS TO BUILD (15 blocks total)
Build these blocks in this exact order. Each is a Gutenberg block with block.json + render.php + view.ts + style.css.

#	Block slug	Backed by	Key animation
1	sk/hero-parallax	site options + media	6-layer parallax (§4)
2	sk/character-reveal	block inner text	Scroll-scrubbed letter color sage→earth
3	sk/philosophy-strip	site options	Horizontal scroll-pinned text strip
4	sk/values-pinned	sk_value CPT	Horizontal pinned cards reveal
5	sk/founders-stack	sk_team CPT	Fanned-deck 3D card stack, click to expand
6	sk/offerings-grid	sk_offering CPT	Stagger reveal, hover-lift, modal open
7	sk/quote-band	site options	Parallax bg + char-reveal quote
8	sk/stories-preview	sk_story CPT	Asymmetric editorial grid
9	sk/journal-grid	post query	Masonry-style Aceternity grid
10	sk/events-upcoming	sk_event CPT	NEW — horizontal scroll cards
11	sk/faq-accordion	sk_faq CPT	Smooth height transitions, +/× icon morph
12	sk/newsletter-card	site options	Single source of truth — input focus halo
13	sk/cta-band	site options	Gold/terra full-bleed band
14	sk/footer-giant	site options	Oversize logo SVG mask + animated decorations
15	sk/announcement-bar	site options	Sticky top, dismissible, slide-down on load
Required CPTs (with REST + meta registration)
Copy// inc/cpt-register.php — register all of these
[
  'sk_offering'    => 'Offerings',
  'sk_team'        => 'Team',
  'sk_story'       => 'Stories',
  'sk_event'       => 'Events',
  'sk_faq'         => 'FAQs',
  'sk_value'       => 'Values',         // NEW
  'sk_announcement'=> 'Announcements',
  'sk_legal'       => 'Legal Pages',
]
Every CPT must have show_in_rest => true AND every custom meta key registered via register_post_meta() with show_in_rest => true (this was missing in v3).

Newsletter Card — CRITICAL: single source of truth
The v3 codebase duplicated the newsletter block across home.php, single.php, category.php with hardcoded Forminator form ID 929. In v10, this is ONE block (sk/newsletter-card). All copy lives in site options:

Copysk_option('newsletter_eyebrow',    'Stay Connected');
sk_option('newsletter_heading',    'Join the <em>Inner Circle</em>');
sk_option('newsletter_body',       'Gentle reminders of stillness...');
sk_option('newsletter_form_id',    929);  // EDITABLE via Customizer
sk_option('newsletter_disclaimer', 'Sacred Kompass respects your privacy.');
Include via <?php echo do_blocks('<!-- wp:sk/newsletter-card /-->'); ?> in templates.

§6 PHASED BUILD PLAN (Jules: execute in this order)
Phase 1 — Foundation (Day 1)
Initialize repo: package.json, tsconfig.json, vite.config.ts, .stylelintrc.json, .eslintrc.json.
Create theme.json with full token set from §1.
Create style.css (theme header), functions.php (thin loader).
Create assets/css/tokens.css, reset.css, base.css, motion.css.
Create inc/enqueue.php — register and enqueue everything.
Create src/lib/motion.ts, smooth-scroll.ts, reveal.ts.
Create src/main.ts that boots Lenis + GSAP and binds reveals.
Phase 1 acceptance test:

npm run build succeeds with zero errors.
Activating the theme on a fresh WP install shows a blank page with correct fonts and background var(--sk-cream).
DevTools: window.SK.motion exists; Lenis is running (smooth scrolling works).
Phase 2 — Hero Parallax + Core Blocks (Days 2-3)
Build sk/hero-parallax block in full (§4).
Build sk/character-reveal block.
Build sk/newsletter-card block (single source of truth).
Build sk/cta-band and sk/announcement-bar.
Build header.php + footer.php with <sk-menu-overlay> Lit component.
Phase 2 acceptance test:

Hero parallax meets all 7 criteria in §4.
Character reveal scrubs cleanly on scroll.
Newsletter card renders identically wherever inserted.
Lighthouse Performance ≥ 90 on /.
Phase 3 — CPTs + Content Blocks (Days 4-5)
Build inc/cpt-register.php — all 8 CPTs + register_post_meta for every custom field.
Build inc/admin-options.php — Customizer panels for all sk_option() keys (no Settings API soup; use the modern Customizer API).
Build blocks 4-11 from §5 (values-pinned through faq-accordion).
Build archive-sk_story.php and single-sk_story.php.
Phase 3 acceptance test:

All 8 CPTs visible in admin; meta fields editable.
GET /wp-json/wp/v2/stories?_embed returns full content with featured image.
Each section block can be inserted via Gutenberg inserter and renders correctly.
Phase 4 — Page Composition + Polish (Day 6)
Build front-page.php that renders the home composition (Gutenberg pattern).
Register a block pattern called "Sacred Kompass Home" that pre-composes all 15 sections.
Build 404.php with character-reveal style "Lost" treatment.
Build sk/footer-giant with oversized SVG logo + decorations.
Phase 4 acceptance test:

New site → activate theme → home page renders complete composition.
All reveals trigger correctly on scroll.
No console errors. No CLS. No FOUT.
Phase 5 — Hardening (Day 7)
Add stylelint rules:
color-no-hex (force token usage)
declaration-property-value-disallowed-list for transition (force var(--ease-*))
selector-max-id, selector-max-specificity
Add ESLint rule banning anonymous dom.onReady() calls.
Add a build-time guard: error if any template-parts/**/*.php contains a text node > 20 chars without sk_option(), __(), or esc_html__().
Run Lighthouse on /, /story/sample, /team. Target: Performance ≥ 95, Accessibility = 100, Best Practices = 100, SEO = 100.
Run axe-core a11y audit. Fix all critical issues.
Write README.md explaining how editors compose pages.
§7 ACCEPTANCE TESTS (run after every phase)
Copy# 1. Build must succeed clean
npm run build && echo "✓ Build OK"

# 2. Lint must pass
npm run lint && echo "✓ Lint OK"

# 3. PHP syntax check on every file
find . -name "*.php" -not -path "./node_modules/*" -exec php -l {} \; | grep -v "No syntax errors" && echo "✗ PHP errors found" || echo "✓ PHP OK"

# 4. No hardcoded hex colors outside tokens.css and theme.json
grep -rE "#[0-9a-fA-F]{3,6}" assets/css blocks --include="*.css" | grep -v "tokens.css" && echo "✗ Hardcoded hex found" || echo "✓ Color tokens OK"

# 5. No hardcoded cubic-bezier outside tokens.css
grep -rn "cubic-bezier" assets/css blocks --include="*.css" | grep -v "tokens.css" && echo "✗ Hardcoded easing" || echo "✓ Easing tokens OK"

# 6. No !important in any file except a documented allowlist
grep -rn "!important" assets/css blocks --include="*.css" | wc -l
# Target: ≤ 5 total, each commented with reason
§8 RULES — DO NOT VIOLATE
No hardcoded copy in templates. Every visible string MUST come from sk_option(), a CPT field, or __() translation.
No !important unless commented with /* !important: required because <reason> */. Target total ≤ 5.
No duplicate selectors across files. If two files style the same class, you've architected wrong.
No raw cubic-bezier() outside tokens.css. Use var(--ease-out) / var(--ease-hero).
No raw transition: ... [0-9]+(s|ms). Use var(--ease-*) and var(--dur-*).
No d1 / d2 / d3 / d4 stagger classes. Use data-reveal data-stagger="0.08" on parent, JS handles the rest.
Every JS module must be named. dom.onReady('HeroParallax', () => {...}) — never anonymous.
All CPTs must register their meta via register_post_meta() with show_in_rest => true.
No global jQuery. Vanilla JS / Lit only.
All images must have explicit width and height attributes to prevent CLS.
§9 CONTENT — REBRANDING NOTES
Crawl https://sacredkompass.org (existing live site) to extract:

Brand voice and existing copy (offerings descriptions, founder bios, story titles, FAQs)
Logo SVG (download and place in assets/images/logo.svg)
Current Forminator form ID for newsletter signup
Existing CPT content to seed via WP-CLI import
The visual identity is completely new (colors + typography in §1) — but the content (text, stories, offerings, team bios) carries over from the existing site.

Generate a scripts/migrate-content.php WP-CLI command that imports content from a WXR export of the old site, mapping old CPTs to new ones:

Copysk_offering (old) → sk_offering (new)
sk_team     (old) → sk_team     (new)
sk_story    (old) → sk_story    (new)
sk_event    (old) → sk_event    (new)
sk_faq      (old) → sk_faq      (new)
post        (old) → post        (new)
§10 DELIVERABLES
When done, the PR should include:

The complete theme in /sacred-kompass/.
A README.md with: installation steps, how to add a new block, how to extend tokens, how to edit content.
A MIGRATION.md mapping old v3 features → new v10 equivalents.
A CHANGELOG.md documenting v10.0.0.
Screenshots of Lighthouse scores in /docs/lighthouse/.
A 60-second screen recording showing the hero parallax in action (use Puppeteer + ffmpeg in CI).
A WP-CLI seed script that creates one demo post per CPT so the theme works out-of-the-box on fresh install.
§11 START
Acknowledge this prompt with your PLAN (file tree, dependencies, phase order, acceptance test list). Wait for approval. Then begin Phase 1.

Remember: the goal is ironhill-grade discipline, not feature count. 4 colors, 2 fonts, 2 easings, 1 reveal pattern. Every line of code should justify its existence.
