import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { EASE, DUR } from './motion';

gsap.registerPlugin(ScrollTrigger);

export function initReveals(): void {
  const reveals = document.querySelectorAll<HTMLElement>('[data-reveal]');

  reveals.forEach((element) => {
    const stagger = element.dataset.stagger ? parseFloat(element.dataset.stagger) : 0;

    gsap.to(element, {
      scrollTrigger: {
        trigger: element,
        start: 'top 85%',
        once: true,
      },
      y: 0,
      opacity: 1,
      duration: DUR.base,
      ease: EASE.out,
      stagger: stagger,
    });
  });
}
