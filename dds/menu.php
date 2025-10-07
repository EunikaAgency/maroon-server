<?php

require_once 'wp-load.php';

$menu_name = 'Practice Areas Menu';
$menu_items = wp_get_nav_menu_items($menu_name);

$menus = [];

// Initialize the menu items and set up children arrays
foreach ($menu_items as $menu_item) {
    $menus[$menu_item->menu_item_parent][] = (object)[
        'ID' => $menu_item->ID,
        'title' => $menu_item->title,
        'url' => $menu_item->url
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php foreach ($menus[0] as $key => $parent_menu) : ?>
                                    <a href="#" class="btn nav-link <?= $key == 1 ? 'active' : '' ?>" id="v-pills-<?= $key ?>-tab" data-toggle="pill" data-target="#v-pills-<?= $key ?>" type="button" role="tab" aria-controls="v-pills-<?= $key ?>" aria-selected="true"><?= $parent_menu->title ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <?php foreach ($menus[0] as $key => $parent_menu) : unset($menus[0]); ?>

                                    <div class="tab-pane fade <?= $key == 1 ? 'show active' : '' ?>" id="v-pills-<?= $key ?>" role="tabpanel" aria-labelledby="v-pills-<?= $key ?>-tab">

                                        <div class="row">
                                            <?php foreach ($menus[$parent_menu->ID] as $menu_item) : ?>
                                                <div class="col-6 mb-3">
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <a href="<?= $menu_item->url ?>"><?= $menu_item->title ?></a>
                                                        <?php if (isset($menus[$menu_item->ID])) : ?>
                                                            <button class="btn"><i class="fas fa-angle-right ml-2"></i></button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>


                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

    <script>
        const menuItems = <?php echo json_encode($menus); ?>;
    </script>
</body>

</html>