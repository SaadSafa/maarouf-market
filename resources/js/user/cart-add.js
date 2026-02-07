// Use event delegation so forms injected via AJAX also get handled.
document.addEventListener('submit', async (event) => {
    const form = event.target.closest('.add-to-cart-form');
    if (!form) return;

    event.preventDefault();

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const formToken = form.querySelector('input[name="_token"]')?.value;
        const headers = { 'X-Requested-With': 'XMLHttpRequest' };
        if (csrfToken || formToken) {
            headers['X-CSRF-TOKEN'] = csrfToken || formToken;
        }

        const body = new FormData(form);
        if (!body.get('_token') && (csrfToken || formToken)) {
            body.append('_token', csrfToken || formToken);
        }

        const response = await fetch(form.action, {
            method: 'POST',
            body,
            credentials: 'same-origin',
            headers
        });

        if (response.status === 419) {
            showToast('Session expired. Retrying...');
            form.submit();
            return;
        }
        if (response.status === 423) {
            const data = await response.json().catch(() => ({}));
            showToast(data.message || 'Ordering is currently paused.');
            return;
        }

        const result = await response.json();

        if (result.success) {
            updateCartCount(result.cartCount);
            showToast("Item added to cart");
            const qtyInput = form.querySelector('input[name="quantity"]');
            if (qtyInput) {
                qtyInput.value = qtyInput.min ? Math.max(1, parseInt(qtyInput.min, 10)) : 1;
            }
            const popover = form.closest('.cart-popover');
            if (popover) {
                popover.classList.remove('is-open');
            }
        }
    } catch (err) {
        console.error('Add to cart error:', err);
    }
});

// Update cart badge count
function updateCartCount(count) {
    const badge = document.querySelector("#cart-count");

    if (!badge) return;

    if (count > 0) {
        badge.textContent = count;
        badge.classList.remove("hidden");
    } else {
        badge.classList.add("hidden");
    }
}

// Simple toast message
/*
function showToast(message) {
    let toast = document.createElement("div");
    toast.className = "fixed top-20 left-1/2 -translate-x-1/2 bg-green-600 text-white px-4 py-2 rounded-full shadow-lg z-50";
    toast.innerText = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2000);
}*/
