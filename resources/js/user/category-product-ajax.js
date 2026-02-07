document.addEventListener("DOMContentLoaded", () => {

    const productContainer = document.getElementById("products-container");
    const gridSelector = "[data-products-grid]";
    const paginationSelector = "[data-pagination]";
    const loaderSelector = "[data-products-loader]";
    const sentinelSelector = "[data-products-sentinel]";
    const storagePrefix = "products:list:";
    let loading = false;
    let nextUrl = null;
    let observer = null;

    // If the home page does not include #products-container, stop.
    if (!productContainer) return;

    const storageKeyFromUrl = (href) => {
        const url = new URL(href, window.location.origin);
        if (url.pathname === "/ajax/products") {
            const current = new URL(window.location.href);
            current.search = url.search;
            url.pathname = current.pathname;
            url.search = current.search;
        }
        // Keep filters/search, but ignore page so we can restore full list state.
        url.searchParams.delete("page");
        return storagePrefix + url.pathname + "?" + url.searchParams.toString();
    };
    let stateKey = storageKeyFromUrl(window.location.href);

    const saveState = () => {
        const grid = productContainer.querySelector(gridSelector);
        if (!grid) return;
        const data = {
            html: grid.innerHTML,
            nextUrl,
            scrollY: window.scrollY
        };
        try {
            sessionStorage.setItem(stateKey, JSON.stringify(data));
        } catch (error) {
            // ignore storage issues
        }
    };

    const restoreState = () => {
        try {
            const raw = sessionStorage.getItem(stateKey);
            if (!raw) return false;
            const data = JSON.parse(raw);
            if (!data || !data.html) return false;

            const grid = productContainer.querySelector(gridSelector);
            if (!grid) return false;

            grid.innerHTML = data.html;
            nextUrl = data.nextUrl || null;

            const pagination = productContainer.querySelector(paginationSelector);
            if (pagination) {
                pagination.classList.add("hidden");
                pagination.dataset.nextUrl = nextUrl || "";
            }

            const scrollTarget = typeof data.scrollY === "number" ? data.scrollY : 0;
            requestAnimationFrame(() => {
                window.scrollTo({ top: scrollTarget, behavior: "auto" });
            });
            return true;
        } catch (error) {
            return false;
        }
    };

    const showLoader = (show) => {
        const loader = productContainer.querySelector(loaderSelector);
        if (!loader) return;
        loader.classList.toggle("hidden", !show);
    };

    const setActiveCategory = (categoryId) => {
        const activeClasses = ["bg-emerald-50", "border-green-500"];
        const inactiveClasses = ["bg-white/90", "border-slate-100"];
        document.querySelectorAll(".category-filter").forEach(button => {
            const isActive = categoryId && button.dataset.category === String(categoryId);
            button.classList.toggle(activeClasses[0], isActive);
            button.classList.toggle(activeClasses[1], isActive);
            button.classList.toggle(inactiveClasses[0], !isActive);
            button.classList.toggle(inactiveClasses[1], !isActive);
        });
    };

    const ensureSentinel = () => {
        let sentinel = productContainer.querySelector(sentinelSelector);
        if (sentinel) return sentinel;
        sentinel = document.createElement("div");
        sentinel.setAttribute("data-products-sentinel", "");
        productContainer.appendChild(sentinel);
        return sentinel;
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

    const updateHistoryPage = (url) => {
        try {
            const next = new URL(url, window.location.origin);
            const current = new URL(window.location.href);
            current.search = next.search;
            window.history.replaceState({}, '', current);
        } catch (error) {
            // ignore
        }
    };

    const parseAndRender = (html, append) => {
        const doc = new DOMParser().parseFromString(html, "text/html");
        const newGrid = doc.querySelector(gridSelector);
        const newPagination = doc.querySelector(paginationSelector);
        const grid = productContainer.querySelector(gridSelector);

        if (!grid || !newGrid) return;

        if (!append) {
            grid.innerHTML = "";
        }

        Array.from(newGrid.children).forEach((child) => {
            grid.appendChild(child);
        });

        nextUrl = newPagination ? newPagination.dataset.nextUrl || null : null;

        const pagination = productContainer.querySelector(paginationSelector);
        if (pagination) {
            pagination.classList.add("hidden");
            pagination.dataset.nextUrl = nextUrl || "";
        }

        if (!nextUrl && observer) {
            observer.disconnect();
            observer = null;
        }
    };

    const loadProducts = (url, append = false) => {
        if (loading) return;
        loading = true;
        showLoader(true);
        const ajaxUrl = toAjaxUrl(url);
        stateKey = storageKeyFromUrl(url);
        fetch(ajaxUrl)
            .then(response => response.text())
            .then(html => {
                parseAndRender(html, append);
                if (!append) {
                    initInfiniteScroll();
                }
                updateHistoryPage(url);
            })
            .catch(err => console.error(err))
            .finally(() => {
                loading = false;
                showLoader(false);
                saveState();
            });
    };

    // Handle category clicks
    document.querySelectorAll(".category-filter").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const categoryId = this.dataset.category;

            const pageUrl = new URL(window.location.href);
            pageUrl.searchParams.set("category", categoryId);
            pageUrl.searchParams.delete("page");
            setActiveCategory(categoryId);
            loadProducts(pageUrl.toString(), false);
        });
    });

    const initInfiniteScroll = () => {
        const pagination = productContainer.querySelector(paginationSelector);
        nextUrl = pagination ? pagination.dataset.nextUrl || null : null;
        if (pagination) pagination.classList.add("hidden");

        const sentinel = ensureSentinel();
        if (!sentinel) return;

        observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                if (!nextUrl || loading) return;
                loadProducts(nextUrl, true);
            });
        }, { rootMargin: "200px" });

        observer.observe(sentinel);
    };

    const restored = restoreState();
    initInfiniteScroll();
    if (!restored) {
        saveState();
    }

    const initialCategory = new URL(window.location.href).searchParams.get("category");
    setActiveCategory(initialCategory);

    let saveTimeout = null;
    window.addEventListener("scroll", () => {
        if (saveTimeout) return;
        saveTimeout = setTimeout(() => {
            saveState();
            saveTimeout = null;
        }, 200);
    });

    window.addEventListener("beforeunload", () => {
        saveState();
    });

});
