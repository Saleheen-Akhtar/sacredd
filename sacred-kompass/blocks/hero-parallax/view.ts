import { initHeroParallax } from '../../src/lib/parallax';

document.querySelectorAll<HTMLElement>('[data-sk-hero]').forEach((root) => {
  initHeroParallax(root, { driftScale: 1, mouseTilt: true });
});
