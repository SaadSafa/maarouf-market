document.addEventListener('click', (event) => {
    const prevButton = event.target.closest('[data-slider-prev]');
    const nextButton = event.target.closest('[data-slider-next]');
    const button = prevButton || nextButton;
    if (!button) {
        return;
    }

    const targetSelector = button.getAttribute(prevButton ? 'data-slider-prev' : 'data-slider-next');
    if (!targetSelector) {
        return;
    }

    const container = document.querySelector(targetSelector);
    if (!container) {
        return;
    }

    const direction = prevButton ? -1 : 1;
    const scrollAmount = Math.max(180, Math.floor(container.clientWidth * 0.7));
    container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
});
