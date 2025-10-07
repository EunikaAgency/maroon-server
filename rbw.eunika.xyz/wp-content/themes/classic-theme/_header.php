<?php
$logo_id = get_theme_mod('custom_logo', 12);
$logo_url = wp_get_attachment_url($logo_id);
?>


<header>

<script>console.log("New Server, Mabilis!")</script>













    <!-- make another full width bar here  and move all menu-contact-info  and menu-social-media  -->
    <div class="header-top navbar-dark bg-teal-blue d-block d-md-flex justify-content-between align-items-center">


        <?php

        $primary_navigation = wp_get_nav_menu_items('contact');

        $menus = [];
        foreach ($primary_navigation as $nav) {
            $menus[$nav->menu_item_parent][] = $nav;
        }

        ?>

        <!-- Contact Information -->
        <ul class="navbar-nav d-lg-flex justify-content-center ml-lg-3">

            <?php foreach ($menus[0] as $menu): ?>
                <?php if (isset($menus[$menu->ID])): ?>


                    <li class="nav-item dropdown" id="menu-item-<?php echo $menu->ID; ?>">
                        <a class="<?php echo implode(' ', $menu->classes); ?> nav-link dropdown-toggle fs-14" href="<?php echo htmlspecialchars($menu->url); ?>"
                            data-toggle="dropdown">
                            <?php echo htmlspecialchars($menu->title); ?>
                        </a>
                        <div class="dropdown-menu">
                            <?php foreach ($menus[$menu->ID] as $child): ?>
                                <a class="dropdown-item fs-14 p-2 <?php echo is_current_page(['link' => $child->url]) ? 'active' : 'nav-link'; ?> "
                                    id="menu-item-<?php echo $child->ID; ?>"
                                    href="<?php echo htmlspecialchars($child->url); ?>">
                                    <i class="<?php echo implode(' ', $child->classes); ?>"></i>
                                    <?php echo htmlspecialchars($child->title); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item" id="menu-item-<?php echo $menu->ID; ?>">
                        <a class="nav-link fs-14 <?php echo is_current_page(['link' => $menu->url]); ?> "
                            href="<?php echo htmlspecialchars($menu->url); ?>">
                            <i class="<?php echo implode(' ', $menu->classes); ?>"></i>
                            <?php echo htmlspecialchars($menu->title); ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>

        </ul>

        <?php


        $primary_navigation = wp_get_nav_menu_items('social-media-links');

        $social_menus = [];
        foreach ($primary_navigation as $nav) {
            $social_menus[$nav->menu_item_parent][] = $nav;
        }

        ?>

        <!-- Social Media Icons -->
        <ul class="navbar-nav justify-content-center d-lg-flex mr-lg-3">


            <?php foreach ($social_menus[0] as $social_menu): ?>
                <?php if (isset($social_menus[$social_menu->ID])): ?>

                    <li class="nav-item dropdown" id="menu-item-<?php echo $social_menu->ID; ?>">
                        <a class="nav-link dropdown-toggle fs-14" href="<?php echo htmlspecialchars($social_menu->url); ?>"
                            data-toggle="dropdown">
                            <?php echo htmlspecialchars($social_menu->title); ?>
                        </a>
                        <div class="dropdown-menu">
                            <?php foreach ($social_menus[$social_menu->ID] as $social_menu_child): ?>
                                <a class="dropdown-item fs-14 p-2 <?php echo is_current_page(['link' => $social_menu_child->url]) ? 'active' : 'nav-link'; ?> "
                                    id="menu-item-<?php echo $social_menu_child->ID; ?>"
                                    href="<?php echo htmlspecialchars($social_menu_child->url); ?>">
                                    <i class="<?php echo implode(' ', $social_menu_child->classes); ?>"></i>

                                    <?= htmlspecialchars($social_menu_child->title) !== "[no label]" ? htmlspecialchars($social_menu_child->title) : "" ?>
                                </a>

                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item" id="menu-item-<?php echo $social_menu->ID; ?>">
                        <a class="nav-link fs-14 <?php echo is_current_page(['link' => $social_menu->url]); ?> "
                            href="<?php echo htmlspecialchars($social_menu->url); ?>">
                            <i class="<?php echo implode(' ', $social_menu->classes); ?>"></i>

                            <?php if( isset($social_menu_child->title) ): ?>
                                <?= htmlspecialchars($social_menu_child->title) !== "[no label]" ? htmlspecialchars($social_menu_child->title) : "" ?>
                            <?php endif; ?>

                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>





        </ul>
    </div>


























    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-dark">
        <div class="container-fluid">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="/">
                <img class="logo" src="/wp-content/uploads/2024/08/red-brick-winery-red-white-logo.png" alt="Red Brick Winery Logo" id="brand-logo">
            </a>

            <!-- Toggler/collapsible Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">

                    <?php


                    $primary_navigation = wp_get_nav_menu_items('Primary');
                    $current_url = home_url($_SERVER['REQUEST_URI']); // Get the current page URL

                    $menus = [];
                    foreach ($primary_navigation as $nav) {
                        $menus[$nav->menu_item_parent][] = $nav;
                    }



                    ?>
                    <?php foreach ($menus[0] as $menu): ?>




                    <?php


                    // echo '<pre>';
                    // print_r( $menu );
                    // echo '</pre>';
                    // die();

                    ?>






                        <?php
                        $is_current = $current_url === rtrim($menu->url, '/'); // Check if the menu URL matches the current URL
                        ?>
                        <?php if (isset($menus[$menu->ID])): ?>
                            <li class="<?php echo implode(' ', $menu->classes); ?> nav-item dropdown <?php echo $is_current ? 'active' : ''; ?>" id="menu-item-<?php echo $menu->ID; ?>">
                                <a class="<?php echo implode(' ', $menu->classes); ?>nav-link dropdown-toggle fs-14 <?php echo $is_current ? 'active' : ''; ?>" href="<?php echo htmlspecialchars($menu->url); ?>"
                                    data-toggle="dropdown">
                                    <?php echo htmlspecialchars($menu->title); ?>
                                </a>
                                <div class="dropdown-menu">
                                    <?php foreach ($menus[$menu->ID] as $child): ?>
                                        <?php
                                        $is_current_child = $current_url === rtrim($child->url, '/'); // Check if the child menu URL matches the current URL
                                        ?>
                                        <a class="dropdown-item fs-14 p-2 <?php echo $is_current_child ? 'active' : ''; ?> <?php echo implode(' ', $child->classes); ?>"
                                            id="menu-item-<?php echo $child->ID; ?>"
                                            href="<?php echo htmlspecialchars($child->url); ?>"><?php echo htmlspecialchars($child->title); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item <?php echo $is_current ? 'active' : ''; ?>" id="menu-item-<?php echo $menu->ID; ?>">
                                <a class="nav-link fs-14 <?php echo $is_current ? 'active' : ''; ?> <?php echo implode(' ', $menu->classes); ?>"
                                    href="<?php echo htmlspecialchars($menu->url); ?>">
                                    <?php echo htmlspecialchars($menu->title); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>




                <!-- WooCommerce Cart Icon and Account Links -->
                <div class="header-woocommerce d-flex justify-content-end align-items-center">
                <?php if (class_exists('WooCommerce')) : ?>

                    <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                    <ul class="navbar-nav ml-auto">
                        <!-- WooCommerce My Account Link -->
                        <li class="nav-item">
                            <a class="nav-link fs-14" href="<?php echo wc_get_account_endpoint_url('dashboard'); ?>">
                                <i class="fas fa-user"></i> My Account
                            </a>
                        </li>
                        
                        <!-- WooCommerce Cart Link (only show if there are items in the cart) -->
                       
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="<?php echo wc_get_cart_url(); ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                    Cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)
                                </a>
                            </li>
                        
                    </ul>
                    <?php endif; ?>
                <?php endif; ?>
                </div>



                <?php
                $primary_navigation = wp_get_nav_menu_items('contact');

                $menus = [];
                foreach ($primary_navigation as $nav) {
                    $menus[$nav->menu_item_parent][] = $nav;
                }
                ?>






            </div>
        </div>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header');
    const navbar = header.querySelector('.navbar');
    const brandLogo = document.querySelector('#brand-logo');
    let stickyTop = 0;

    function applyHeaderBehavior() {
        header.style.position = 'fixed';
        // header.style.top = `${stickyTop}px`;/

        navbar.classList.add('navbar-light', 'nav-expanded', 'shadow');
        navbar.classList.remove('navbar-dark');

        // Change logo when scrolled or hovered
        brandLogo.setAttribute('src', 'https://rbw.eunika.xyz/wp-content/uploads/2024/09/red-brick-winery-red-white-logo-black.png');
    }

    function revertHeaderBehavior() {
        header.style.position = 'absolute';
        header.style.background = 'transparent';
        header.style.top = 'unset';

        navbar.classList.remove('shadow', 'nav-expanded');
        navbar.classList.add('navbar-dark');

        // Revert logo when not scrolled or hovered
        brandLogo.setAttribute('src', '/wp-content/uploads/2024/08/red-brick-winery-red-white-logo.png');
    }

    // Check if #wpadminbar exists and update stickyTop
    if (document.querySelector('#wpadminbar')) {
        stickyTop = document.querySelector('#wpadminbar').offsetHeight;
    }

    // Handle scroll behavior
    window.addEventListener('scroll', () => {
        if (window.scrollY > 150) {
            applyHeaderBehavior();
        } else {
            revertHeaderBehavior();
        }
    });

    // Handle hover behavior for desktop
    if (window.innerWidth > 768) { // Assuming desktop if width is greater than 768px
        header.addEventListener('mouseenter', applyHeaderBehavior);
        header.addEventListener('mouseleave', () => {
            if (window.scrollY <= 150) {
                revertHeaderBehavior();
            }
        });
    }
});



</script>