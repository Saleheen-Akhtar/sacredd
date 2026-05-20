import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll<HTMLElement>('[data-footer-giant]').forEach((root) => {
  const logo = root.querySelector<HTMLElement>('[data-footer-logo]');
  if (!logo) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  gsap.from(logo, {
    yPercent: 50,
    opacity: 0,
    ease: "none",
    scrollTrigger: {
      trigger: root,
      start: "top bottom",
      end: "bottom bottom",
      scrub: true
    }
  });
});
