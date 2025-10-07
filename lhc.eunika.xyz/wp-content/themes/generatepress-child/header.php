<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata('body'); ?>>
    <?php
    /**
     * wp_body_open hook.
     *
     * @since 2.3
     */
    do_action('wp_body_open'); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.

    // Cache the primary menu
    $primary_menu = get_transient('cached_primary_menu');
    if (!$primary_menu) {
        $primary_menu = wp_get_nav_menu_items('Primary');
        set_transient('cached_primary_menu', $primary_menu, 12 * HOUR_IN_SECONDS); // Cache for 12 hours
    }

    // Cache the nav buttons
    $nav_buttons = get_transient('cached_nav_buttons');
    if (!$nav_buttons) {
        $nav_buttons = wp_get_nav_menu_items('nav-buttons');
        set_transient('cached_nav_buttons', $nav_buttons, 12 * HOUR_IN_SECONDS); // Cache for 12 hours
    }

    // Organize primary menu items into child menus
    $child_menus = [];
    foreach ($primary_menu as $key => $menu) {
        if ($menu->menu_item_parent) {
            $child_menus[$menu->menu_item_parent][] = $menu;
            unset($primary_menu[$key]); // Remove child menu item from primary menu
        }
    }
    ?>

    <header class="clean <?= get_post_type() ?>">

        <nav class="navbar navbar-expand-lg">

            <a class="navbar-brand" href="<?= home_url() ?>">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if (has_custom_logo()) {
                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" title="' . get_bloginfo('name') . '" width="150">';
                } else {
                    echo '<h1>' . get_bloginfo('name') . '</h1>';
                }
                ?>
            </a>

            <!-- Mobile nav buttons -->
            <ul class="nav-buttons mx-0 d-lg-none d-flex">
                <?php foreach ($nav_buttons as $_nav_button) : ?>
                    <li class="nav-item">
                        <a class="<?= implode(' ', $_nav_button->classes) ?>" href="<?= $_nav_button->url ?>">
                            <?= $_nav_button->title ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Navbar toggle button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <?php foreach ($primary_menu as $menu1) : ?>
                        <li class="nav-item focus-line item-<?= $menu1->ID ?>">
                            <?php if (isset($child_menus[$menu1->ID])) : ?>
                                <!-- Dropdown Menu -->
                                <a class="nav-link dropdown-toggle" href="<?= $menu1->url ?>" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?= $menu1->title ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <?php foreach ($child_menus[$menu1->ID] as $menu2) : ?>
                                        <a class="dropdown-item" href="<?= $menu2->url ?>"><?= $menu2->title ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <!-- Regular Menu Item -->
                                <a href="<?= $menu1->url ?>" class="nav-link <?= implode(' ', $menu1->classes) ?>"><?= $menu1->title ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Desktop nav buttons -->
                <ul class="nav-buttons mx-0 d-none d-lg-flex">
                    <?php foreach ($nav_buttons as $_nav_button) : ?>
                        <li class="nav-item">
                            <a class="<?= implode(' ', $_nav_button->classes) ?>" href="<?= $_nav_button->url ?>">
                                <?= $_nav_button->title ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>

        </nav>
    </header>

    <div <?php generate_do_attr('page'); ?>>
        <?php
        /**
         * generate_inside_site_container hook.
         *
         * @since 2.4
         */
        do_action('generate_inside_site_container');
        ?>
        <div <?php generate_do_attr('site-content'); ?>>
            <?php
            /**
             * generate_inside_container hook.
             *
             * @since 0.1
             */
            do_action('generate_inside_container');
            ?>
