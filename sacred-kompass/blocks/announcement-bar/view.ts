document.querySelectorAll<HTMLElement>('[data-announcement]').forEach((root) => {
  const closeBtn = root.querySelector('[data-announcement-close]');

  // Check local storage
  if (localStorage.getItem('sk-announcement-dismissed') !== 'true') {
    // Slide down after a short delay
    setTimeout(() => {
      root.classList.add('sk-announcement--visible');
    }, 1000);
  } else {
    root.classList.add('sk-announcement--hidden');
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      root.classList.remove('sk-announcement--visible');
      setTimeout(() => {
        root.classList.add('sk-announcement--hidden');
      }, 800); // Wait for transition
      localStorage.setItem('sk-announcement-dismissed', 'true');
    });
  }
});
