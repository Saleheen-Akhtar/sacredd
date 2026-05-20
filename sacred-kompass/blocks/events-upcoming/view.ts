import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll<HTMLElement>('[data-events-upcoming]').forEach((root) => {
  const track = root.querySelector<HTMLElement>('[data-events-track]');
  if (!track) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || window.innerWidth < 768) {
    // Rely on native horizontal scroll
    return;
  }

  // Horizontal scroll linked to vertical scroll
  const getScrollAmount = () => -(track.scrollWidth - window.innerWidth + (parseFloat(getComputedStyle(root).paddingLeft) || 0));

  gsap.to(track, {
    x: getScrollAmount,
    ease: "none",
    scrollTrigger: {
      trigger: root,
      start: "top center",
      end: () => `+=${track.scrollWidth}`,
      pin: false, // Don't pin for this one, just move as you scroll past
      scrub: 1,
      invalidateOnRefresh: true
    }
  });
});
