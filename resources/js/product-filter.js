// Alpine.js component voor product filtering adhv ajax returnt object met state en methods die gebruikt worden in de view
function productFilter() {
    return {
        selectedCategories: [],
        selectedBrands: [],
        productCount: 0,
        route: "",

        init() {
            // zoeken naar element met data-products-route
            const $section = this.$el.closest("[data-products-route]");
            // als section of data-products-route niet gevonden wordt, throw een error
            if (!$section || !$section.dataset.productsRoute) {
                throw new Error(
                    "productFilter: data-products-route attribute is required on parent element"
                );
            }
            // zet route naar de waarde van het data-products-route attribuut dus /products
            this.route = $section.dataset.productsRoute;

            // parseren van query string (deel na ? in URL) naar URLSearchParams interface om parameters te lezen
            const urlParams = new URLSearchParams(window.location.search);
            // haalt alle category values uit de query string, converteert string-waarden naar integers en slaat op in selectedCategories
            this.selectedCategories = urlParams
                .getAll("categories[]")
                .map((id) => parseInt(id));
            // haalt alle brand values uit de query string, converteert string-waarden naar integers en slaat op in selectedBrands
            this.selectedBrands = urlParams
                .getAll("brands[]")
                .map((id) => parseInt(id));

            // bij laden van de pagina, haal het aantal op uit de html, waarde word server side gezet in de view
            const $productCountDisplay = this.getProductCountDisplay();
            // als er een product count display is dan sla de waarde op in productCount
            if ($productCountDisplay) {
                this.productCount =
                    parseInt($productCountDisplay.dataset.productCount) || 0;
            }

            // event listeners zetten op paginatie links voor ajax zonder volledige page reloads
            this.setupPaginationHandlers();
        },

        // haalt count op uit data-product-count attribuut
        getProductCountDisplay() {
            return document.querySelector("[data-product-count]");
        },

        // voegt id toe aan array of verwijdert het
        toggleItem(array, id) {
            const numId = parseInt(id);
            // zoekt of het al id array zit
            const index = array.indexOf(numId);
            // geeft index terug als het gevonden is, anders -1, als het -1 is word het toegevoegd aan de array
            index > -1 ? array.splice(index, 1) : array.push(numId);
            // haalt nieuwe producten op via fetchProducts functie
            this.fetchProducts();
        },

        // voegt category id toe aan array of verwijdert het
        toggleCategory(categoryId) {
            this.toggleItem(this.selectedCategories, categoryId);
        },

        // voegt brand id toe aan array of verwijdert het
        toggleBrand(brandId) {
            this.toggleItem(this.selectedBrands, brandId);
        },

        // verwijdert alle filters (categorieën en merken)
        clearFilters() {
            // reset de selectedCategories en selectedBrands arrays
            this.selectedCategories = [];
            this.selectedBrands = [];

            // haalt nieuwe producten op via fetchProducts functie
            this.fetchProducts();
        },

        // bouwt een URLSearchParams object met alle filterparameters voor de AJAX-request
        buildParams(page = 1) {
            // maakt een nieuw leeg URLSearchParams object met allemaal methodes
            const params = new URLSearchParams();

            // loopt over selected categories en brands arrays en voegt entries toe aan het params object
            this.selectedCategories.forEach((id) =>
                params.append("categories[]", id)
            );
            this.selectedBrands.forEach((id) => params.append("brands[]", id));

            // haal huidige query string uit de URL, nieuw object om parameters te lezen
            const urlParams = new URLSearchParams(window.location.search);
            // haalt search query op
            const searchQuery = urlParams.get("search")?.trim();
            // als er een search query is, voegt deze toe aan de params object
            if (searchQuery) {
                params.append("search", searchQuery);
            }

            // als de pagina groter is dan 1, voegt deze toe aan de params object
            if (page > 1) {
                params.append("page", page);
            }

            return params;
        },

        // bouwt een URL met alle filterparameters voor de AJAX-request, als er params zijn dan voegt deze toe aan de url, anders wordt de huidige url gebruikt /products
        buildUrl(params) {
            return params.toString()
                ? `${window.location.pathname}?${params.toString()}`
                : window.location.pathname;
        },

        async fetchProducts(page = 1, skipPushState = false) {
            // opbouwen params voor fetch request
            const params = this.buildParams(page);

            // fetch request met params
            try {
                const response = await fetch(
                    `${this.route}?${params.toString()}`,
                    {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            Accept: "application/json",
                        },
                    }
                );

                if (!response.ok)
                    throw new Error("Network response was not ok");

                const data = await response.json();

                // als er products zijn en container bestaat, update de products grid
                const $productsContainer =
                    document.getElementById("products-container");
                if ($productsContainer && data.products) {
                    $productsContainer.innerHTML = data.products;
                }

                // als er pagination is en container bestaat, update de pagination
                const $paginationContainer = document.getElementById(
                    "pagination-container"
                );
                if ($paginationContainer && data.pagination !== undefined) {
                    $paginationContainer.innerHTML = data.pagination;
                }

                // als er een count is, update de product count
                if (data.count !== undefined) {
                    this.productCount = data.count;
                    this.updateProductCount();
                }

                // update de url met de nieuwe params, zodat url gescyncd blijft met de actieve filters
                // skip pushState als we reageren op popstate (browser navigatie)
                if (!skipPushState) {
                    window.history.pushState({}, "", this.buildUrl(params));
                }
            } catch (error) {
                console.error("Error fetching products:", error);
                window.location.href = `${this.route}?${params.toString()}`;
            }
        },

        // updaten van de product count display boven grid
        updateProductCount() {
            const $productCountDisplay = this.getProductCountDisplay();
            // als er een product count display is,
            if ($productCountDisplay) {
                // update de text, indien meervoud dan s toevoegen
                $productCountDisplay.textContent = `${
                    this.productCount
                } Product${this.productCount !== 1 ? "s" : ""}`;
                // update het data-product-count attribuut met de nieuwe count
                $productCountDisplay.setAttribute(
                    "data-product-count",
                    this.productCount
                );
            }
        },

        // opzetten van event listeners voor paginatie links
        setupPaginationHandlers() {
            // als er al event listeners zijn dan return
            if (window.productFilterPaginationSetup) return;

            // event listener voor clicks
            document.addEventListener(
                "click",
                (e) => {
                    // zoekt naar dichtstbijzijnde a tag in pagination container en slaat op in link
                    const $link = e.target.closest("#pagination-container a");
                    // als er geen link is of de href niet page bevat dan return
                    if (!$link?.href.includes("page")) return;

                    e.preventDefault();

                    // maakt een nieuw URL object van de href van de link
                    const url = new URL($link.href);
                    // leest de page parameter uit de url en converteert naar een integer
                    const page = parseInt(url.searchParams.get("page") || "1");

                    const $section = document.querySelector(
                        '[x-data*="productFilter"]'
                    );
                    // haalt alpine component op
                    const component = $section?._x_dataStack?.[0];
                    // haalt nieuwe producten op via fetchProducts functie als component bestaat
                    component?.fetchProducts(page);
                },
                true
            );

            // zet de global variable op true om te voorkomen dat de event listeners meerdere keren worden toegevoegd
            window.productFilterPaginationSetup = true;
        },
    };
}

// maak globaal beschikbaar voor Alpine.js
window.productFilter = productFilter;
