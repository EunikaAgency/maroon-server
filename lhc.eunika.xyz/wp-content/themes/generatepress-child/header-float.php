<?php
$primary_menu = wp_get_nav_menu_items('Primary');

$child_menus = array();
foreach ($primary_menu as $key => $menu) {
    if ($menu->menu_item_parent) {
        $child_menus[$menu->menu_item_parent][] = $menu;
        unset($primary_menu[$key]);
    }
}
?>

<header class="<?= get_post_type() ?>">
    <nav class="navbar navbar-expand-md navbar-transparent bg-transparent px-5">
        <a class="navbar-brand" href="<?= home_url() ?>">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if (has_custom_logo()) {
                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" width="150">';
            } else {
                echo '<h1>' . get_bloginfo('name') . '</h1>';
            }
            ?>
        </a>

        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mx-auto">

                <?php foreach ($primary_menu as $menu1) : ?>

                    <?php if (!isset($child_menus[$menu1->ID])) : ?>
                        <li class="nav-item focus-line item-<?= $menu1->ID ?>">
                            <a href="<?= $menu1->url ?>" class="nav-link <?= implode(' ', $menu1->classes) ?>"><?= $menu1->title ?></a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item cdropdown item-<?= $menu1->ID ?>">
                            <a class="nav-link  focus-line" href="<?= $menu1->url ?>"><?= $menu1->title ?></a>

                            <ul class="navbar-nav">
                                <?php foreach ($child_menus[$menu1->ID] as $menu2) : ?>
                                    <?php if (!isset($child_menus[$menu2->ID])) : ?>
                                        <li class="nav-item item-<?= $menu2->ID ?>">
                                            <a class="nav-link <?= implode(' ', $menu1->classes) ?>" href="<?= $menu2->url ?>"><?= $menu2->title ?></a>
                                        </li>
                                    <?php else : ?>
                                        <li class="nav-item cdropdown cdropright  item-<?= $menu2->ID ?>">
                                            <a class="nav-link" href="<?= $menu2->url ?>"><?= $menu2->title ?></a>

                                            <ul class="navbar-nav">
                                                <?php foreach ($child_menus[$menu2->ID] as $menu3) : ?>
                                                    <li class="nav-item  item-<?= $menu3->ID ?>">
                                                        <a class="nav-link  <?= implode(' ', $menu1->classes) ?>" href="<?= $menu3->url ?>"><?= $menu3->title ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>
        </div>
    </nav>
</header>