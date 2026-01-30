document.addEventListener("DOMContentLoaded", () => {

    const productContainer = document.getElementById("products-container");

    // If the home page does not include #products-container, stop.
    if (!productContainer) return;

    const loadProducts = (url) => {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                productContainer.innerHTML = html;
            })
            .catch(err => console.error(err));
    };

    const toAjaxUrl = (href) => {
        try {
            const url = new URL(href, window.location.origin);
            if (url.pathname === '/ajax/products') {
                return url.toString();
            }

            url.pathname = '/ajax/products';
            return url.toString();
        } catch (error) {
            return href;
        }
    };

    // Handle category clicks
    document.querySelectorAll(".category-filter").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const categoryId = this.dataset.category;

            loadProducts(`/ajax/products?category=${categoryId}`);
        });
    });

    // Handle pagination links inside the injected fragment via delegation
    productContainer.addEventListener("click", (e) => {
        const link = e.target.closest("nav[role='navigation'] a, .pagination a");
        if (!link) return;

        e.preventDefault();
        loadProducts(toAjaxUrl(link.href));
    });

});
