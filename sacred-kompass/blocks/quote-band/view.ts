import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll<HTMLElement>('[data-quote-band]').forEach((root) => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const chars = root.querySelectorAll<HTMLElement>('.sk-quote-char');
    chars.forEach(c => c.style.opacity = '1');
    return;
  }

  // Background Parallax
  const bg = root.querySelector<HTMLElement>('[data-parallax-bg]');
  if (bg) {
    gsap.to(bg, {
      yPercent: 20, // Move up as you scroll down
      ease: "none",
      scrollTrigger: {
        trigger: root,
        start: "top bottom",
        end: "bottom top",
        scrub: true
      }
    });
  }

  // Character Reveal
  const chars = root.querySelectorAll<HTMLElement>('.sk-quote-char');
  if (chars.length) {
    gsap.to(chars, {
      opacity: 1,
      stagger: 0.05,
      ease: "none",
      scrollTrigger: {
        trigger: root,
        start: "top 70%",
        end: "center center",
        scrub: 0.5
      }
    });
  }
});
