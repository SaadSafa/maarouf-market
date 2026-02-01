// Show modal
window.openCancelModal = function () {
    const modal = document.getElementById("cancel-modal");
    modal.classList.remove("hidden");
};

// Hide modal
window.closeCancelModal = function () {
    const modal = document.getElementById("cancel-modal");
    modal.classList.add("hidden");
};

document.addEventListener("DOMContentLoaded", () => {

    const cancelBtn = document.getElementById("cancel-order-btn");
    const confirmBtn = document.getElementById("confirm-cancel");

    if (!cancelBtn || !confirmBtn) return;

    const orderId = cancelBtn.dataset.id;

    confirmBtn.addEventListener("click", () => {

        fetch(`/orders/${orderId}/cancel`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json",
            },
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {

                    // update status badge
                    const badge = document.getElementById("order-status-badge");
                    badge.textContent = "Cancelled";
                    badge.className =
                        `ml-1 inline-block px-2 py-1 rounded-full text-white text-[11px] ${data.badgeColor}`;

                    // remove cancel button
                    cancelBtn.remove();

                    // close modal
                    closeCancelModal();

                    // show toast
                    if (window.showToast) showToast(data.message);
                }
            })
            .catch((err) => console.error("Cancel error:", err));
    });
});
