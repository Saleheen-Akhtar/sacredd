import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initCharacterReveal(root: HTMLElement): () => void {
  const chars = Array.from(root.querySelectorAll<HTMLElement>('.sk-character-reveal__char'));
  if (!chars.length) return () => {};

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    chars.forEach(char => {
      char.style.color = 'var(--sk-earth)';
    });
    return () => {};
  }

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: root,
      start: 'top 80%',
      end: 'bottom 40%',
      scrub: 0.5,
    },
  });

  tl.to(chars, {
    color: 'var(--sk-earth)',
    stagger: 0.1,
    ease: 'none',
  });

  return () => {
    if (tl.scrollTrigger) tl.scrollTrigger.kill();
  };
}
