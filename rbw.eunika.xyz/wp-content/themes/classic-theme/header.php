<?php
$logo_id = get_theme_mod('custom_logo', 12);
$logo_url = wp_get_attachment_url($logo_id);

// Menus
$contact_menu = wp_get_nav_menu_items('contact') ?: [];
$social_menu = wp_get_nav_menu_items('social-media-links') ?: [];
$primary_menu = wp_get_nav_menu_items('Primary') ?: [];

// Grouped Menus
$group_menu = function ($items) {
    $grouped = [];
    foreach ($items as $item) {
        $grouped[$item->menu_item_parent][] = $item;
    }
    return $grouped;
};

$contact_menus = $group_menu($contact_menu);
$social_menus = $group_menu($social_menu);
$primary_menus = $group_menu($primary_menu);

$current_url = home_url($_SERVER['REQUEST_URI']);
?>

<header>
    <script>console.log("New Server, Mabilis!")</script>

    <!-- Top Bar -->
    <div class="header-top navbar-dark bg-teal-blue d-block d-md-flex justify-content-between align-items-center px-3 py-2">
        <ul class="navbar-nav d-flex flex-row gap-2">
            <?php foreach ($contact_menus[0] ?? [] as $item): ?>
                <li class="nav-item">
                    <a class="nav-link text-white fs-14" href="<?= esc_url($item->url) ?>"><?= esc_html($item->title) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <ul class="navbar-nav d-flex flex-row gap-2">
            <?php foreach ($social_menus[0] ?? [] as $item): ?>
                <li class="nav-item">
                    <a class="nav-link text-white fs-14" href="<?= esc_url($item->url) ?>">
                        <i class="<?= esc_attr(implode(' ', $item->classes)) ?>"></i> <?= esc_html($item->title !== '[no label]' ? $item->title : '') ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img id="brand-logo" class="logo" src="<?= esc_url($logo_url) ?>" alt="Red Brick Winery Logo">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <?php foreach ($primary_menus[0] ?? [] as $menu): ?>
                        <?php $is_current = $current_url === rtrim($menu->url, '/'); ?>
                        <?php if (isset($primary_menus[$menu->ID])): ?>
                            <li class="nav-item dropdown <?= $is_current ? 'active' : '' ?>">
                                <a class="nav-link dropdown-toggle fs-14" href="<?= esc_url($menu->url) ?>" data-toggle="dropdown">
                                    <?= esc_html($menu->title) ?>
                                </a>
                                <div class="dropdown-menu">
                                    <?php foreach ($primary_menus[$menu->ID] as $child): ?>
                                        <a class="dropdown-item fs-14 p-2 <?= $current_url === rtrim($child->url, '/') ? 'active' : '' ?>"
                                           href="<?= esc_url($child->url) ?>">
                                            <?= esc_html($child->title) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item <?= $is_current ? 'active' : '' ?>">
                                <a class="nav-link fs-14" href="<?= esc_url($menu->url) ?>">
                                    <?= esc_html($menu->title) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

                <!-- WooCommerce -->
                <div class="header-woocommerce d-flex align-items-center">
                    <?php if (class_exists('WooCommerce') && WC()->cart && WC()->cart->get_cart_contents_count() > 0): ?>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="<?= wc_get_account_endpoint_url('dashboard') ?>">
                                    <i class="fas fa-user"></i> My Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="<?= wc_get_cart_url() ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                    Cart (<?= WC()->cart->get_cart_contents_count() ?>)
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Header JS -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.querySelector('header');
        const navbar = header.querySelector('.navbar');
        const brandLogo = document.querySelector('#brand-logo');
        const stickyTop = document.querySelector('#wpadminbar')?.offsetHeight || 0;

        function applyHeaderBehavior() {
            header.style.position = 'fixed';
            navbar.classList.add('navbar-light', 'nav-expanded', 'shadow');
            navbar.classList.remove('navbar-dark');
            brandLogo.src = "https://rbw.eunika.xyz/wp-content/uploads/2024/09/red-brick-winery-red-white-logo-black.png";
        }

        function revertHeaderBehavior() {
            header.style.position = 'absolute';
            header.style.top = 'unset';
            header.style.background = 'transparent';
            navbar.classList.remove('shadow', 'nav-expanded');
            navbar.classList.add('navbar-dark');
            brandLogo.src = "<?= esc_url($logo_url) ?>";
        }

        window.addEventListener('scroll', () => {
            if (window.scrollY > 150) applyHeaderBehavior();
            else revertHeaderBehavior();
        });

        if (window.innerWidth > 768) {
            header.addEventListener('mouseenter', applyHeaderBehavior);
            header.addEventListener('mouseleave', () => {
                if (window.scrollY <= 150) revertHeaderBehavior();
            });
        }
    });
</script>
