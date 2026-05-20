import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll<HTMLElement>('[data-values-pinned]').forEach((root) => {
  const track = root.querySelector<HTMLElement>('[data-values-track]');
  if (!track) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    track.style.flexWrap = 'wrap';
    return;
  }

  const getScrollAmount = () => {
    return -(track.scrollWidth - window.innerWidth + (parseFloat(getComputedStyle(root).paddingLeft) || 0) * 2);
  };

  gsap.to(track, {
    x: getScrollAmount,
    ease: "none",
    scrollTrigger: {
      trigger: root,
      start: "top top",
      end: () => `+=${getScrollAmount() * -1}`,
      pin: true,
      scrub: 1,
      invalidateOnRefresh: true
    }
  });
});
