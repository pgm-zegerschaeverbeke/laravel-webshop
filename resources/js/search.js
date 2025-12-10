// Alpine.js component voor zoeken in header, werkt samen met productFilter()
function globalSearch() {
    return {
        searchQuery: "",
        productsRoute: "/products",

        // initialisatie van de component, uitgevoerd bij mount
        init() {
            if (this.isOnProductsPage()) {
                // haalt query string uit de URL en converteert naar URLSearchParams object
                const urlParams = new URLSearchParams(window.location.search);
                // haalt search query op en slaat op in searchQuery
                this.searchQuery = urlParams.get("search") || "";
                // syncroniseert de search query met de URL, als je op back button drukt dat de search query state ook aanpast word
                this.syncFromURL();
            }
        },

        // controleert of de huidige pagina de products page is
        isOnProductsPage() {
            // huidige url path
            const path = window.location.pathname;
            // als het path gelijk is aan de products route of het path begint met de products route dan return true
            return (
                path === this.productsRoute ||
                path.startsWith(this.productsRoute + "/")
            );
        },

        // haalt het productFilter() component op en slaat op in $section
        getProductFilterComponent() {
            const $section = document.querySelector(
                '[x-data*="productFilter"]'
            );
            // als er een section is dan return het component
            return $section?._x_dataStack?.[0];
        },

        // synchroniseert de search state met de browser history bij back/forward
        syncFromURL() {
            // event listener voor popstate, bij back/forward button
            window.addEventListener("popstate", () => {
                // haalt query string uit de URL en converteert naar URLSearchParams object
                const urlParams = new URLSearchParams(window.location.search);
                // haalt search query op en slaat op in searchQuery, dus eigenlijk terug naar de vorige search query, meestal leeg
                this.searchQuery = urlParams.get("search") || "";

                if (this.isOnProductsPage()) {
                    const component = this.getProductFilterComponent();
                    // skip pushState omdat we reageren op popstate (browser navigatie)
                    component?.fetchProducts(1, true);
                }
            });
        },

        // wordt aangeroepen tijdens het typen in de searchbar (met debounce) elke 500ms, enkel als de huidige pagina de products page is
        handleSearchInput() {
            if (this.isOnProductsPage()) {
                this.updateSearchOnProductsPage();
            }
        },

        // wordt aangeroepen bij enter of bij wissen van de searchbar
        handleSearch() {
            // trimt query en slaat op in variabele
            const query = this.searchQuery.trim();

            // als je op de products page bent, update via ajax en realtime via de updateSearchOnProductsPage functie
            if (this.isOnProductsPage()) {
                this.updateSearchOnProductsPage();

            } 
            // Als je niet op products bent en er is een query: navigeer naar products pagina met de query
            else if (query.length > 0) {
                window.location.href = `${
                    this.productsRoute
                }?search=${encodeURIComponent(query)}`;
            }
        },

        // update search query op de products page via AJAX, zonder page reload
        updateSearchOnProductsPage() {
            const query = this.searchQuery.trim();
            const urlParams = new URLSearchParams(window.location.search);
            // controleert of er al een search query is
            const hadSearch = urlParams.has("search");

            // als er een query is, voeg toe of update, als leeg is verwijder
            query.length > 0
                ? urlParams.set("search", query)
                : urlParams.delete("search");
            // wis de page parameter, altijd terug naar 1
            urlParams.delete("page");

            // bouw nieuwe url string, indien geen parameters dan /products
            const newUrl = urlParams.toString()
                ? `${window.location.pathname}?${urlParams.toString()}`
                : window.location.pathname;

            // als er al een search was, gebruik replaceState (update huidige entry)
            if (hadSearch) {
                window.history.replaceState({}, "", newUrl);
            } 
            // anders gebruik pushState (nieuwe entry voor eerste search)
            else {
                window.history.pushState({}, "", newUrl);
            }

            // haalt het productFilter() component op en haalt searched products op via fetchProducts functie
            const component = this.getProductFilterComponent();
            component?.fetchProducts(1, true);
        },
    };
}

// maak globaal beschikbaar voor Alpine.js
window.globalSearch = globalSearch;
