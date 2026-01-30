const closeAllPopovers = () => {
    document.querySelectorAll('.cart-popover.is-open').forEach((popover) => {
        popover.classList.remove('is-open');
    });
};

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-cart-toggle]');
    if (toggle) {
        const popover = toggle.closest('.cart-popover');
        if (!popover) return;

        const wasOpen = popover.classList.contains('is-open');
        closeAllPopovers();
        if (!wasOpen) {
            popover.classList.add('is-open');
        }
        event.preventDefault();
        return;
    }

    if (!event.target.closest('.cart-popover')) {
        closeAllPopovers();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeAllPopovers();
    }
});
