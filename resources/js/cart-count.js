document.addEventListener('DOMContentLoaded', () => {

    const badge = document.getElementById('cart-count');
    if (!badge) return;

    function refreshCartCount() {
        fetch('/cart/count')
            .then(res => res.json())
            .then(count => {
                badge.innerText = count;

                if (count > 0) {
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            })
            .catch(err => console.error('Cart count error:', err));
    }

    // Refresh on normal page load
    refreshCartCount();

    // Refresh when using BACK or FORWARD (bfcache restore)
    window.addEventListener('pageshow', function (event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            refreshCartCount();
        }
    });

    //handles ALL browsers when page becomes visible again
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            refreshCartCount();
        }
    });

});
