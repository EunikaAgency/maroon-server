<?php

$current_post_id = get_the_ID();
$ids = [];
$posts = [];
$post_type = 'post';

if (isset($args['ids']) && $args['ids']) {
    $ids = explode(',', str_replace(' ', '', $args['ids']));
}

if (!empty($ids)) {
    foreach ($ids as $id) {
        $posts[] = get_post($id);
    }
}

if (isset($args['post_type']) && $args['post_type']) {
    $post_type = $args['post_type'];
}

if (empty($posts)) {
    $posts = get_posts([
        'numberposts' => -1,
        'post_type' => $post_type,
        'post_status' => 'publish'
    ]);
}
?>


<div class="srcs mb-5">
    <?php if (isset($args['title'])) : ?>
        <h4 class="font-weight-bold my-3 text-primary" style="font-size: 22px;"><?= $args['title'] ?></h4>
    <?php endif; ?>

    <?php foreach ($posts as $post) : ?>
        <?php if (isset($post->post_title)) : ?>
            <a class="w-100 <?= $post->ID == $current_post_id ? 'active' : '' ?>" href="<?= get_permalink($post->ID) ?>">
                <div class="w-100 d-flex align-items-center justify-content-between border rounded mb-3 px-4 py-3">
                    <span><?= $post->post_title ?></span>
                    <i class="fas fa-angle-right"></i>
                </div>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>

</div>

<style>
    .srcs a:hover {
        text-decoration: none;
    }

    .srcs a:hover,
    .srcs a.active {
        color: #fff;
    }

    .srcs a:hover div,
    .srcs a.active div {
        background-color: #279e64;
    }
</style>