document.addEventListener("DOMContentLoaded", function () {
  // ============================= //
  // ELEMENT REFERENCES
  // ============================= //
  const drawer = document.getElementById("drawer");
  const toggleBtn = document.getElementById("menuToggle");
  const iconBurger = toggleBtn?.querySelector(".icon-burger");
  const iconClose = toggleBtn?.querySelector(".icon-close");
  const mobileMenu = document.getElementById("mobileMenu");
  const widget = document.querySelector(".threads-header-widget");
  const header = widget?.querySelector(".header");
  const topBar = widget?.querySelector(".top-bar");
  const searchToggle = document.querySelector('.nav-right .icon[aria-label="Search"]');
  const searchPanel = document.getElementById("headerSearchPanel");
  const searchInput = document.getElementById("headerSearchInput");
  const closeBtn = document.getElementById("closeSearch");
  const productsBox = document.getElementById("productsResults");
  const articlesBox = document.getElementById("articlesResults");
  const tabButtons = document.querySelectorAll(".tab-button");
  const desktopDropdowns = document.querySelectorAll(".nav-left .has-dropdown");

  let lastScroll = 0;
  let timer = null;

  // ============================= //
  // DRAWER FUNCTIONS
  // ============================= //
  function openDrawer() {
    drawer.classList.add("open");
    drawer.setAttribute("aria-hidden", "false");
    toggleBtn.setAttribute("aria-expanded", "true");
    iconBurger?.classList.add("hidden");
    iconClose?.classList.remove("hidden");
    document.body.style.overflow = "hidden";
    closeSearch(); // ensure search panel closes
  }

  function closeDrawer() {
    drawer.classList.remove("open");
    drawer.setAttribute("aria-hidden", "true");
    toggleBtn.setAttribute("aria-expanded", "false");
    iconClose?.classList.add("hidden");
    iconBurger?.classList.remove("hidden");
    document.body.style.overflow = "";
  }

  toggleBtn?.addEventListener("click", () => {
    drawer.classList.contains("open") ? closeDrawer() : openDrawer();
  });

  // ============================= //
  // DESKTOP DROPDOWNS
  // ============================= //
  desktopDropdowns.forEach((dropdown) => {
    const link = dropdown.querySelector("a[data-dropdown-toggle]");
    let hoverTimeout;

    dropdown.addEventListener("mouseenter", () => {
      clearTimeout(hoverTimeout);
      dropdown.classList.add("dropdown-open");
      link?.setAttribute("aria-expanded", "true");
    });

    dropdown.addEventListener("mouseleave", () => {
      hoverTimeout = setTimeout(() => {
        dropdown.classList.remove("dropdown-open");
        link?.setAttribute("aria-expanded", "false");
      }, 100);
    });

    link?.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        dropdown.classList.toggle("dropdown-open");
        link.setAttribute(
          "aria-expanded",
          dropdown.classList.contains("dropdown-open") ? "true" : "false"
        );
      }
    });
  });

  document.addEventListener("click", (e) => {
    if (!e.target.closest(".nav-left .has-dropdown")) {
      desktopDropdowns.forEach((dropdown) => {
        dropdown.classList.remove("dropdown-open");
        const link = dropdown.querySelector("a[data-dropdown-toggle]");
        link?.setAttribute("aria-expanded", "false");
      });
    }
  });

  // ============================= //
  // MOBILE DRAWER SUBMENUS
  // ============================= //
  mobileMenu?.addEventListener("click", (e) => {
    const dropdownLink = e.target.closest(".has-dropdown > a");
    if (!dropdownLink) return;

    e.preventDefault();
    const parentLi = dropdownLink.parentElement;

    // Close others
    mobileMenu.querySelectorAll(".has-dropdown").forEach((item) => {
      if (item !== parentLi) {
        item.classList.remove("mobile-open");
        item.querySelector(".swap-text")?.classList.remove("swap-click");
      }
    });

    // Toggle
    parentLi.classList.toggle("mobile-open");

    // Animate
    const swapText = dropdownLink.querySelector(".swap-text");
    if (swapText) {
      swapText.classList.remove("swap-click");
      void swapText.offsetWidth; // reflow
      swapText.classList.add("swap-click");
    }

    dropdownLink.setAttribute(
      "aria-expanded",
      parentLi.classList.contains("mobile-open") ? "true" : "false"
    );
  });

  // ============================= //
  // HEADER STICKY BEHAVIOR
  // ============================= //
  window.addEventListener("scroll", function () {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
      widget?.classList.remove("hide");
      header?.classList.remove("stuck");
      if (topBar) topBar.style.display = "block";
      return;
    }

    if (currentScroll > lastScroll) {
      // Scrolling down → hide header and close search
      widget?.classList.add("hide");
      closeSearch(); // Close search when header starts hiding
    } else {
      // Scrolling up → show header only
      widget?.classList.remove("hide");
      header?.classList.add("stuck");
      if (topBar) topBar.style.display = "none";
    }

    lastScroll = currentScroll;
  });

  // ============================= //
  // SEARCH PANEL
  // ============================= //
  function closeSearch() {
    if (searchPanel) {
      searchPanel.classList.remove("active");
      searchPanel.setAttribute("aria-hidden", "true");
    }
  }

  function openSearch() {
    if (searchPanel) {
      searchPanel.classList.add("active");
      searchPanel.setAttribute("aria-hidden", "false");
      searchInput?.focus();
      closeDrawer(); // ensure drawer closes if open
    }
  }

  searchToggle?.addEventListener("click", (e) => {
    e.preventDefault();
    openSearch();
  });

  closeBtn?.addEventListener("click", closeSearch);

  // REMOVED: The old auto-close search on scroll logic since we handle it in the main scroll handler now

  // ESC closes everything
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeDrawer();
      closeSearch();
      desktopDropdowns.forEach((d) => d.classList.remove("dropdown-open"));
    }
  });

  // ============================= //
  // SEARCH AUTOCOMPLETE + TABS
  // ============================= //
  tabButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      tabButtons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      document.querySelectorAll(".results-grid").forEach((r) => r.classList.remove("active"));
      document.getElementById(btn.dataset.tab + "Results")?.classList.add("active");
    });
  });

  searchInput?.addEventListener("input", function () {
    const query = this.value.trim();
    clearTimeout(timer);

    if (query.length < 2) {
      productsBox.innerHTML = "";
      articlesBox.innerHTML = "";
      return;
    }

    timer = setTimeout(() => {
      // Products
      fetch(`${threadsSearch.ajaxurl}?action=product_search&q=${encodeURIComponent(query)}`)
        .then((res) => res.json())
        .then((data) => {
          productsBox.innerHTML = data.length
            ? data
                .map(
                  (item) => `
              <a href="${item.url}" class="suggestion-item">
                <img src="${item.image}" alt="${item.title}" />
                <span>${item.title}</span>
                <span class="price">${item.price}</span>
              </a>`
                )
                .join("")
            : `<p class="no-results">No products found</p>`;
        });

      // Articles
      fetch(`${threadsSearch.ajaxurl}?action=article_search&q=${encodeURIComponent(query)}`)
        .then((res) => res.json())
        .then((data) => {
          articlesBox.innerHTML = data.length
            ? data
                .map(
                  (item) => `
              <a href="${item.url}" class="suggestion-item">
                <span>${item.title}</span>
              </a>`
                )
                .join("")
            : `<p class="no-results">No articles found</p>`;
        });
    }, 300);
  });
});

