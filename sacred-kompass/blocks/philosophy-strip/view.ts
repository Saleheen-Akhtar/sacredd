import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll<HTMLElement>('[data-philosophy-strip]').forEach((root) => {
  const inner = root.querySelector<HTMLElement>('[data-strip-inner]');
  if (!inner) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    inner.style.paddingLeft = 'var(--sk-section-x)';
    inner.style.whiteSpace = 'normal';
    root.style.height = 'auto';
    root.style.padding = 'var(--sk-section-y) 0';
    return;
  }

  const getScrollAmount = () => {
    return -(inner.scrollWidth - window.innerWidth);
  };

  gsap.to(inner, {
    x: getScrollAmount,
    ease: "none",
    scrollTrigger: {
      trigger: root,
      start: "center center",
      end: () => `+=${inner.scrollWidth}`,
      pin: true,
      scrub: 1,
      invalidateOnRefresh: true
    }
  });
});
