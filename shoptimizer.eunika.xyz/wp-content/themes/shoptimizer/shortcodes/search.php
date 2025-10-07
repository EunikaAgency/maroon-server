<?php
if (!defined('ABSPATH')) exit;

function threads_search_shortcode($atts) {
    ob_start(); ?>
    
<div class="threads-search-shortcode">
    <div class="search-input-wrapper">
        <span class="search-logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                <circle cx="11" cy="11" r="7"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </span>
        <input type="search" id="threadsSearchInput" placeholder="Search" />
    </div>

    <div class="search-results" style="display:none;">
        <div id="threadsProductsResults" class="results-grid active"></div>
        <div id="threadsArticlesResults" class="results-grid"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("threadsSearchInput");
    const productsBox = document.getElementById("threadsProductsResults");
    const articlesBox = document.getElementById("threadsArticlesResults");
    const searchResults = document.querySelector(".threads-search-shortcode .search-results");
    let timer = null;

    searchInput?.addEventListener("input", function () {
        const query = this.value.trim();
        clearTimeout(timer);

        if (query.length < 2) { 
            productsBox.innerHTML = ""; 
            articlesBox.innerHTML = ""; 
            searchResults.style.display = "none";
            return; 
        }

        timer = setTimeout(() => {
            const ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

            Promise.all([
                fetch(`${ajaxurl}?action=product_search&q=${encodeURIComponent(query)}`).then(res => res.json()),
                fetch(`${ajaxurl}?action=article_search&q=${encodeURIComponent(query)}`).then(res => res.json())
            ]).then(([products, articles]) => {

                // Products
                productsBox.innerHTML = products.length ? products.map(item => `
                    <a href="${item.url}" class="suggestion-item">
                        <img src="${item.image}" alt="${item.title}" />
                        <span class="title">${item.title}</span>
                        <span class="price">${item.price}</span>
                    </a>`).join('') : '';

                // Articles
                articlesBox.innerHTML = articles.length ? articles.map(item => `
                    <a href="${item.url}" class="suggestion-item">
                        <span class="title">${item.title}</span>
                    </a>`).join('') : '';

                if ((products && products.length) || (articles && articles.length)) {
                    searchResults.style.display = "grid";
                } else {
                    searchResults.style.display = "none";
                }
            });
        }, 300);
    });
});
</script>

<style>
.threads-search-shortcode { position: relative; max-width:1300px; }
.threads-search-shortcode .search-input-wrapper { position: relative; display: flex; align-items: center; }
.threads-search-shortcode .search-logo { position: absolute; left: 10px; font-size: 18px; pointer-events: none; }
.threads-search-shortcode input[type=search] { width: 100%; padding: 8px 8px 8px 30px; border-radius: 0; font-size: 12px; }

.results-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 10px;
}

.suggestion-item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    text-decoration: none;
    padding: 5px;
    transition: transform 0.2s ease;
    cursor: pointer;
}

.suggestion-item:hover {
    transform: translateY(-3px);
}

.suggestion-item img {
    width: 100%;
    height: auto;
    object-fit: cover;
    margin-bottom: 5px;
}

/* Hover effect on the title text itself */
.suggestion-item .title {
    display: block;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.suggestion-item:hover .title {
    opacity: 0.7;          /* slightly fade on hover */
    transform: translateY(-2px); /* small vertical movement */
}
</style>
<?php
return ob_get_clean();
}

// Register the shortcode
add_shortcode('threads_search', 'threads_search_shortcode');
