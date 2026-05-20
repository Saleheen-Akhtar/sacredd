import { initCharacterReveal } from '../../src/lib/character-reveal';

document.querySelectorAll<HTMLElement>('[data-character-reveal]').forEach((root) => {
  initCharacterReveal(root);
});
