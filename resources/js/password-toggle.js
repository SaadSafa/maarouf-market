document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-toggle-target]');
    if (!button) {
        return;
    }

    const targetSelector = button.getAttribute('data-toggle-target');
    if (!targetSelector) {
        return;
    }

    const input = document.querySelector(targetSelector);
    if (!input) {
        return;
    }

    const nextType = input.type === 'text' ? 'password' : 'text';
    input.type = nextType;

    const showOpen = nextType === 'text';
    const openIcon = button.querySelector('[data-eye="open"]');
    const closedIcon = button.querySelector('[data-eye="closed"]');

    if (openIcon && closedIcon) {
        openIcon.classList.toggle('hidden', !showOpen);
        closedIcon.classList.toggle('hidden', showOpen);
    }
});
