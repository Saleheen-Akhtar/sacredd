import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);

export interface HeroParallaxConfig {
  driftScale?: number;
  mouseTilt?: boolean;
}

export function initHeroParallax(
  root: HTMLElement,
  cfg: HeroParallaxConfig = {}
): () => void {
  const { driftScale = 1, mouseTilt = true } = cfg;
  const layers = Array.from(root.querySelectorAll<HTMLElement>('[data-layer]'));
  if (!layers.length) return () => {};

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return () => {};
  }

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
        scrub: 0.8,
      },
    });
    tl.to(layer, { y: -drift, ease: 'none' }, 0);
    if (fade) tl.to(layer, { opacity: 0.0, ease: 'none' }, 0);

    if (tl.scrollTrigger) triggers.push(tl.scrollTrigger);
  });

  let mouseHandler: ((e: PointerEvent) => void) | null = null;
  if (mouseTilt && window.matchMedia('(pointer: fine)').matches) {
    const stage = root.querySelector<HTMLElement>('[data-stage]');
    if (stage) {
      const tiltAmt = layers.map((_, i) => (i + 1) * 4);
      mouseHandler = (e: PointerEvent) => {
        const rect = root.getBoundingClientRect();
        const cx = (e.clientX - rect.left) / rect.width  - 0.5;
        const cy = (e.clientY - rect.top)  / rect.height - 0.5;
        layers.forEach((layer, i) => {
          gsap.to(layer, {
            x: cx * tiltAmt[i] * -1,
            duration: 0.8,
            ease: 'power2.out',
            overwrite: 'auto',
          });
        });
      };
      root.addEventListener('pointermove', mouseHandler, { passive: true });
    }
  }

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

  return () => {
    triggers.forEach(t => t.kill());
    if (mouseHandler) root.removeEventListener('pointermove', mouseHandler);
  };
}
