import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll<HTMLElement>('.sk-story-card__image-wrapper').forEach((wrapper) => {
  const img = wrapper.querySelector<HTMLElement>('[data-parallax-img]');
  if (!img) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  // Subtle image parallax effect within the wrapper
  gsap.fromTo(img,
    { yPercent: -10, scale: 1.1 },
    {
      yPercent: 10,
      ease: "none",
      scrollTrigger: {
        trigger: wrapper,
        start: "top bottom",
        end: "bottom top",
        scrub: true
      }
    }
  );
});
