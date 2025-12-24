document.addEventListener("DOMContentLoaded", () => {

    const productContainer = document.getElementById("products-container");

    // If the home page does not include #products-container, stop.
    if (!productContainer) return;

    // Handle category clicks
    document.querySelectorAll(".category-filter").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const categoryId = this.dataset.category;

            fetch(`/ajax/products?category=${categoryId}`)
                .then(response => response.text())
                .then(html => {
                    productContainer.innerHTML = html;
                })
                .catch(err => console.error(err));
        });
    });

});
