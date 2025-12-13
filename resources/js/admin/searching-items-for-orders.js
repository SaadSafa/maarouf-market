document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("productSearch");
    const resultsBox = document.getElementById("searchResults");
    const productId = document.getElementById("productId");

    let debounce;

    input.addEventListener("input", () => {
        clearTimeout(debounce);
        const query = input.value.trim();

        if (query.length == 0) {
            resultsBox.classList.add("hidden");
            return;
        }

        // Delay API calls (debounce)
        debounce = setTimeout(() => {
            fetch(`/admin/search-products?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    let html = "";
                    data.forEach(item => {
                        html += `
                          <div class="p-2.5 hover:bg-gray-100 cursor-pointer resultItem"
                               data-id="${item.id}"
                               data-name="${item.name}"
                               data-price="${item.price}">
                                ${item.name} (${Number(item.price).toLocaleString()} LBP)
                          </div>
                        `;
                    });

                    resultsBox.innerHTML = html;
                    resultsBox.classList.remove("hidden");
                });
        }, 250);
    });

    // Click selection
    resultsBox.addEventListener("click", (e) => {
        const item = e.target.closest(".resultItem");
        if (!item) return;

        input.value = item.dataset.name;
        productId.value = item.dataset.id;

        resultsBox.classList.add("hidden");
        console.log("Selected Product ID:", item.dataset.id);
    });

    // Hide dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!resultsBox.contains(e.target) && e.target !== input) {
            resultsBox.classList.add("hidden");
        }
    });
});

