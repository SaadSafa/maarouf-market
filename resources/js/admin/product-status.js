document.querySelectorAll('.btnstatus').forEach(btn => {

    btn.addEventListener('click', function () {

        const productId = this.dataset.id;
        const currentStatus = Number(this.dataset.status);
        const newStatus = currentStatus === 1 ? 0 : 1;
        
        this.textContent = "Changing... "

        fetch(`/admin/products/${productId}/update-status`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.csrf
            },
            body: JSON.stringify({
                is_active: newStatus
            })
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {
                // update dataset
                this.dataset.status = newStatus;

                // update text
                this.textContent = newStatus ? "In Stock" : "Out of Stock";

                // update colors
                if (newStatus === 1) {
                    this.classList.remove("bg-amber-50", "text-amber-700");
                    this.classList.add("bg-emerald-50", "text-emerald-700");
                } else {
                    this.classList.remove("bg-emerald-50", "text-emerald-700");
                    this.classList.add("bg-amber-50", "text-amber-700");
                }
            }
        });
    });
});
