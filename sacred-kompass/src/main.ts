import { initSmoothScroll } from './lib/smooth-scroll';
import { initReveals } from './lib/reveal';
import { EASE, DUR } from './lib/motion';

import './components/sk-menu-overlay';

// Export motion globally as per phase 1 acceptance criteria
(window as any).SK = (window as any).SK || {};
(window as any).SK.motion = { EASE, DUR };

document.addEventListener('DOMContentLoaded', () => {
  initSmoothScroll();
  initReveals();
});
