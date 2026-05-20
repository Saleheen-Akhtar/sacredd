import { gsap } from 'gsap';

document.querySelectorAll<HTMLElement>('[data-faq-accordion]').forEach((root) => {
  const triggers = root.querySelectorAll<HTMLButtonElement>('[data-faq-trigger]');

  triggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
      const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
      const content = trigger.nextElementSibling as HTMLElement;

      // Close others (optional accordion behavior)
      triggers.forEach(t => {
        if (t !== trigger && t.getAttribute('aria-expanded') === 'true') {
          t.setAttribute('aria-expanded', 'false');
          gsap.to(t.nextElementSibling, { height: 0, duration: 0.4, ease: 'power2.out' });
        }
      });

      trigger.setAttribute('aria-expanded', (!isExpanded).toString());

      if (isExpanded) {
        gsap.to(content, { height: 0, duration: 0.4, ease: 'power2.out' });
      } else {
        gsap.set(content, { height: 'auto' });
        const height = content.offsetHeight;
        gsap.fromTo(content, { height: 0 }, { height, duration: 0.4, ease: 'power2.out' });
      }
    });
  });
});
