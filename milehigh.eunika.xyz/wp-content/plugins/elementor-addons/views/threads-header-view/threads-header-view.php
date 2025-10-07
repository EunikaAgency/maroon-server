<?php
$announcement = $settings['announcement_text'] ?? '';
$logo_url     = $settings['logo']['url'] ?? EA_ADDONS_URL . 'assets/images/2kthreads-logo.png';
$menu_id      = $settings['menu'] ?? 0;

// Cart settings
$cart_type = $settings['cart_type'] ?? 'default';
$cart_template = $settings['cart_template'] ?? '';
$custom_cart_html = $settings['custom_cart_html'] ?? '';
$show_cart_count = $settings['show_cart_count'] ?? 'yes';
$cart_url_override = $settings['cart_url_override']['url'] ?? '';

// Get logo dimensions
$logo_width = '';
$logo_height = '';
if (isset($settings['logo']['id']) && $settings['logo']['id']) {
    $attachment_id = $settings['logo']['id'];
    $image_meta = wp_get_attachment_metadata($attachment_id);
    if ($image_meta && isset($image_meta['width'], $image_meta['height'])) {
        $logo_width = $image_meta['width'];
        $logo_height = $image_meta['height'];
    }
}
if (!$logo_width || !$logo_height) {
    $logo_width = 210;
    $logo_height = 60;
}

// Cart URL
$cart_url = $cart_url_override ?: (function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#');

// Cart count
$cart_count = 0;
if (function_exists('WC') && WC()->cart) {
    $cart_count = WC()->cart->get_cart_contents_count();
}

// Render cart
function render_cart_content($cart_type, $settings, $cart_url, $cart_count, $show_cart_count) {
    switch ($cart_type) {
        case 'shoptimizer':
            if (function_exists('shoptimizer_header_cart')) {
                echo '<div class="shoptimizer-cart-wrapper custom-cart-icon">';
                shoptimizer_header_cart();
                echo '</div>';
            } else {
                render_default_cart($cart_url, $cart_count, $show_cart_count);
            }
            break;
        case 'elementor_template':
            if (!empty($settings['cart_template'])) {
                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display(
                    $settings['cart_template'],
                    true
                );
            } else {
                render_default_cart($cart_url, $cart_count, $show_cart_count);
            }
            break;
        case 'custom_html':
            if (!empty($settings['custom_cart_html'])) {
                echo '<div class="custom-cart-content">';
                echo do_shortcode(wp_kses_post($settings['custom_cart_html']));
                echo '</div>';
            } else {
                render_default_cart($cart_url, $cart_count, $show_cart_count);
            }
            break;
        case 'default':
        default:
            render_default_cart($cart_url, $cart_count, $show_cart_count);
            break;
    }
}

function render_default_cart($cart_url, $cart_count, $show_cart_count) { ?>
    <a class="icon cart-icon" href="<?php echo esc_url($cart_url); ?>" aria-label="Cart">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
            <circle cx="9" cy="20" r="1"/>
            <circle cx="16" cy="20" r="1"/>
            <path d="M1 1h4l2.6 12.4A2 2 0 0 0 9.6 15h7.8a2 2 0 0 0 2-1.6L22 6H6"/>
        </svg>
        <?php if ($show_cart_count === 'yes' && $cart_count > 0) : ?>
            <span class="cart-count"><?php echo esc_html($cart_count); ?></span>
        <?php endif; ?>
    </a>
<?php }
?>

<div class="threads-header-widget">
    <div class="top-bar"><?php echo esc_html($announcement); ?></div>

    <header class="header sticky-on-scroll-up">
        <div class="nav">
            <!-- Hamburger -->
            <button class="hamburger" id="menuToggle" aria-label="Open menu" aria-expanded="false">
                <span class="icon-burger">☰</span>
                <span class="icon-close hidden">✕</span>
            </button>

            <!-- Left Menu -->
            <nav class="nav-left" aria-label="Primary">
                <?php
                if ($menu_id) {
                    wp_nav_menu([
                        'menu' => $menu_id,
                        'container' => false,
                        'menu_class' => '',
                        'items_wrap' => '<ul>%3$s</ul>',
                        'fallback_cb' => false,
                        'walker' => new \EA_Addons\Threads_Nav_Walker(),
                    ]);
                }
                ?>
            </nav>

            <!-- Logo -->
            <div class="logo-wrap">
                <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Site Logo">
                    <img src="<?php echo esc_url($logo_url); ?>" 
                         alt="Site Logo"
                         width="<?php echo esc_attr($logo_width); ?>"
                         height="<?php echo esc_attr($logo_height); ?>"
                         loading="eager">
                </a>
            </div>

            <!-- Right Utilities -->
            <nav class="nav-right" aria-label="Utilities">
                <ul>
                    <!-- Search -->
                    <li>
                        <a class="icon" href="#" aria-label="Search">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <circle cx="11" cy="11" r="7"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            <span class="label">Search</span>
                        </a>
                    </li>

                    <!-- Account -->
                    <li class="account-dropdown">
                        <a class="icon account-toggle" href="#" aria-label="Account">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M20 21a8 8 0 1 0-16 0"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </a>
                        <div class="account-menu" aria-hidden="true">
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>" class="login-btn">My Account</a>
                                <a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="create-account">Logout</a>
                            <?php else : ?>
                                <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>" class="login-btn">LOG IN</a>
                                <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>?action=register" class="create-account">Create account</a>
                            <?php endif; ?>
                        </div>
                    </li>

                    <!-- Cart -->
                    <li class="cart-slot">
                        <?php render_cart_content($cart_type, $settings, $cart_url, $cart_count, $show_cart_count); ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 🔎 Search Panel -->
     <div style="justify-content: center; align-items: center; position: relative;">
        <div class="header-search-panel" id="headerSearchPanel" aria-hidden="true">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-input-wrap">
                    <svg class="search-icon" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="11" cy="11" r="7"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="search" id="headerSearchInput" class="search-field" 
                        placeholder="WHAT ARE YOU LOOKING FOR" name="s" autocomplete="off"/>
                    <input type="hidden" name="post_type" value="product" />
                    <button type="button" class="search-close" id="closeSearch">✕</button>
                </div>
            </form>

            <!-- Tabs -->
            <div class="search-tabs">
                <button class="tab-button active" data-tab="products">Products</button>
                <!-- <button class="tab-button" data-tab="articles">Articles</button> -->
            </div>

            <!-- Results -->
            <div class="search-results">
                <div id="productsResults" class="results-grid active"></div>
                <div id="articlesResults" class="results-grid"></div>
            </div>
        </div>
    </div>



    <!-- Mobile Drawer -->
    <aside class="drawer" id="drawer" aria-hidden="true">
        <div class="drawer-inner">
            <div class="drawer-menu" id="mobileMenu">
                <?php
                if ($menu_id) {
                    wp_nav_menu([
                        'menu'        => $menu_id,
                        'container'   => false,
                        'menu_class'  => '',
                        'items_wrap'  => '<ul>%3$s</ul>',
                        'fallback_cb' => false,
                        'walker'      => new \EA_Addons\Threads_Nav_Walker(),
                    ]);
                }
                ?>
            </div>
            <div class="mobile-cart">
                <?php render_cart_content($cart_type, $settings, $cart_url, $cart_count, $show_cart_count); ?>
            </div>
        </div>
    </aside>
</div>

<style>
/* Search Panel Base Styles */

.account-dropdown { position: relative; }
.account-menu { position: absolute; top: 120%; right: 0; background: #fff; border: 1px solid #ddd; padding: 15px; min-width: 200px; display: none; z-index: 1000; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.account-menu::before { content: ""; position: absolute; top: -6px; right: 15px; border-width: 6px; border-style: solid; border-color: transparent transparent #fff transparent; }
.account-menu .login-btn { display: flex; align-items: center; justify-content: center; background: #000; color: #fff !important; padding: 10px; text-decoration: none; font-weight: bold; margin-bottom: 10px; transition: background 0.2s; }
.account-menu .login-btn:hover { background: #333; }
.account-menu .login-btn svg { margin-right: 8px; }
.account-menu .create-account { display: block; text-align: center; font-size: 13px; text-decoration: underline; color: #000; }
.account-menu .create-account:hover { color: #555; }
.cart-count { position: absolute; top: -8px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center; line-height: 1; }
.header-5 .shoptimizer-cart .cart-contents .amount { display: none; }
.header-5 .shoptimizer-cart .cart-contents .count { display: none; }
.cart-slot { position: relative; }
.cart-icon { position: relative; display: inline-block; }
.custom-cart-content { display: contents; }
.shoptimizer-cart-wrapper { display: contents; }
.additional-nav { display: contents; }
.header-5 .shoptimizer-cart a.cart-contents { padding: 0; border: none; line-height: 55px; }
.mobile-cart { padding: 20px; border-top: 1px solid #eee; margin-top: 20px; }
.custom-cart-icon .shoptimizer-cart a.cart-contents::before { content: ''; display: inline-block; width: 18px; height: 18px; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='9' cy='20' r='1'/%3E%3Ccircle cx='16' cy='20' r='1'/%3E%3Cpath d='M1 1h4l2.6 12.4A2 2 0 0 0 9.6 15h7.8a2 2 0 0 0 2-1.6L22 6H6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-size: contain; vertical-align: middle; margin-right: 5px; }
.custom-cart-icon .shoptimizer-cart .fa, .custom-cart-icon .shoptimizer-cart .dashicons, .custom-cart-icon .shoptimizer-cart svg:first-child { display: none !important; }
.custom-cart-icon .shoptimizer-cart .cart-contents-count { position: absolute; top: -8px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center; line-height: 1; }
.search-suggestions { position: absolute; top: 100%; left: 0; width: 100%; background: #111; border-top: 1px solid #333; max-height: 400px; overflow-y: auto; z-index: 2000; }
@media (max-width: 1300px) { .search-form, .search-tabs, .search-results { max-width: 100%; padding-left: 20px; padding-right: 20px; } }
@media (max-width: 768px) { .results-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; } .search-form { padding: 15px 20px 30px 20px; } .search-results { padding: 15px 20px; max-height: 70vh; } }
@media (max-width: 480px) { .results-grid { grid-template-columns: 1fr; } .search-tabs { padding: 10px 15px; gap: 15px; } }


</style>

 <script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggle = document.querySelector(".account-toggle");
        const menu = document.querySelector(".account-menu");

        if (toggle && menu) {
            toggle.addEventListener("click", function(e) {
                e.preventDefault();
                menu.style.display = (menu.style.display === "block") ? "none" : "block";
            });

            // Close if clicking outside
            document.addEventListener("click", function(e) {
                if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                    menu.style.display = "none";
                }
            });
        }
    });
</script>