document.addEventListener("DOMContentLoaded", () => {

    // Quantity increase
    document.querySelectorAll(".qty-inc").forEach(btn => {
        btn.addEventListener("click", () => {
            let parent = btn.closest(".cart-item");
            let input = parent.querySelector(".qty-input");
            input.value = parseInt(input.value) + 1;
            updateQuantity(parent);
        });
    });

    // Quantity decrease
    document.querySelectorAll(".qty-dec").forEach(btn => {
        btn.addEventListener("click", () => {
            let parent = btn.closest(".cart-item");
            let input = parent.querySelector(".qty-input");
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
                updateQuantity(parent);
            }
        });
    });

    // Removing item
    document.querySelectorAll(".remove-item").forEach(btn => {
        btn.addEventListener("click", () => {
            let parent = btn.closest(".cart-item");
            removeItem(parent);
        });
    });

});

// AJAX — Update Quantity
function updateQuantity(item) {
    let id = item.dataset.id;
    let qty = item.querySelector(".qty-input").value;

    fetch(`/cart/update/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(res => res.json())
    .then(data => refreshCartItem(item, data));
}

// AJAX — Remove Item
function removeItem(item) {
    let id = item.dataset.id;

    fetch(`/cart/remove/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(res => res.json())
    .then((data) => {

        // remove item visually
        item.remove();

        // update total
        refreshTotals();

        //update cart badge count
        const badge = document.getElementById("cart-count");
        if(badge){
            if(data.cartCount > 0) {
                badge.innerHTML = data.cartCount;
                badge.classList.remove("hidden");
            } else{
                badge.classList.add("hidden");
            }
        }
    });
}

// Update UI for one item
function refreshCartItem(item, data) {
    item.querySelector(".line-total").innerText = `${data.lineTotal} LBP`;
    refreshTotals();
}

// Recalculate total
function refreshTotals() {
    let total = 0;

    document.querySelectorAll(".cart-item").forEach(item => {
        total += parseInt(item.querySelector(".line-total").innerText.replace(/[^0-9]/g, ""));
    });

    document.getElementById("cart-total").innerText = `${total.toLocaleString()} LBP`;
}

// Fix Back-Forward Cache issue on Cart page
window.addEventListener("pageshow", function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        window.location.reload();
    }
});

