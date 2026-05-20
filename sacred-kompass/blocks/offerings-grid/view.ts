document.querySelectorAll<HTMLElement>('[data-modal-trigger]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.modalTrigger;
    // In a real implementation, this would fetch data via REST or display a pre-rendered modal
    console.log(`Open modal for offering ${id}`);
    alert(`Offering ${id} clicked. Modal implementation would go here.`);
  });
});
