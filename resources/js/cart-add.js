document.addEventListener("DOMContentLoaded", () => {

    // Handle Add to Cart AJAX
    document.querySelectorAll('.add-to-cart-form').forEach(form => {

        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevent full reload

            const url = this.action;
            const formData = new FormData(this);

            try {
                const response = await fetch(url, {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    updateCartCount(result.cartCount);
                    showToast("Item added to cart");
                }

            } catch (err) {
                console.error("Add to cart error:", err);
            }
        });
    });

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
