(function () {
    const navigation = document.querySelector(".site-navbar");
    if (!navigation) return;

    if (!window.bootstrap) {
        const toggle = navigation.querySelector('[data-bs-toggle="collapse"]');
        const collapse = navigation.querySelector(".navbar-collapse");

        if (toggle && collapse) {
            toggle.addEventListener("click", function () {
                const isOpen = collapse.classList.toggle("show");
                toggle.setAttribute("aria-expanded", String(isOpen));
            });
        }

        navigation.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(toggleDropdown => {
            toggleDropdown.addEventListener("click", function (event) {
                event.preventDefault();
                const menu = toggleDropdown.parentElement.querySelector(".dropdown-menu");
                const isOpen = menu.classList.toggle("show");
                toggleDropdown.setAttribute("aria-expanded", String(isOpen));
            });
        });

        document.addEventListener("click", function (event) {
            if (!(event.target instanceof Element) || navigation.contains(event.target)) return;

            navigation.querySelectorAll(".dropdown-menu.show").forEach(menu => {
                menu.classList.remove("show");
                menu.parentElement.querySelector('[data-bs-toggle="dropdown"]').setAttribute("aria-expanded", "false");
            });
        });

        document.addEventListener("keydown", function (event) {
            if (event.key !== "Escape") return;

            navigation.querySelectorAll(".dropdown-menu.show").forEach(menu => {
                menu.classList.remove("show");
                menu.parentElement.querySelector('[data-bs-toggle="dropdown"]').setAttribute("aria-expanded", "false");
            });

            if (collapse && collapse.classList.contains("show")) {
                collapse.classList.remove("show");
                toggle.setAttribute("aria-expanded", "false");
            }
        });
    }

    const searchForm = navigation.querySelector(".navbar-search");
    if (!searchForm) return;

    const searchInput = searchForm.querySelector('input[name="q"]');
    const destinationContainer = document.getElementById("destinasiContainer");
    const params = new URLSearchParams(window.location.search);
    const initialQuery = params.get("q") || params.get("kategori") || "";
    searchInput.value = initialQuery;

    function filterDestinations(query) {
        if (!destinationContainer) return;

        const normalizedQuery = query.trim().toLocaleLowerCase("id");
        const cards = Array.from(destinationContainer.querySelectorAll(".destination-card"));
        let visibleCount = 0;

        cards.forEach(card => {
            const column = card.closest('[class*="col-"]') || card;
            const matches = !normalizedQuery || card.textContent.toLocaleLowerCase("id").includes(normalizedQuery);
            column.hidden = !matches;
            if (matches) visibleCount += 1;
        });

        let emptyState = destinationContainer.querySelector("#navbarSearchEmpty");
        if (cards.length > 0 && visibleCount === 0) {
            if (!emptyState) {
                emptyState = document.createElement("div");
                emptyState.id = "navbarSearchEmpty";
                emptyState.className = "destination-state";
                emptyState.setAttribute("role", "status");
                emptyState.innerHTML = '<i class="bi bi-search"></i><p class="mb-0">Destinasi tidak ditemukan. Coba kata kunci lain.</p>';
                destinationContainer.appendChild(emptyState);
            }
        } else if (emptyState) {
            emptyState.remove();
        }
    }

    if (destinationContainer) {
        const observer = new MutationObserver(() => filterDestinations(searchInput.value));
        observer.observe(destinationContainer, { childList: true, subtree: true });
        filterDestinations(initialQuery);
    }

    searchForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const query = searchInput.value.trim();

        if (!destinationContainer) {
            const searchUrl = query
                ? `index.html?q=${encodeURIComponent(query)}#destinasi`
                : "index.html#destinasi";
            window.location.href = searchUrl;
            return;
        }

        const searchUrl = query
            ? `index.html?q=${encodeURIComponent(query)}#destinasi`
            : "index.html#destinasi";
        window.history.replaceState(null, "", searchUrl);
        filterDestinations(query);
        document.getElementById("destinasi").scrollIntoView({ behavior: "smooth" });
    });
})();
