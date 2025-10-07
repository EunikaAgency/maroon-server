<?php
$exclude_posts = ['attachment', 'e-floating-buttons', 'elementor_library', 'haru_header', 'haru_footer', 'haru_megamenu', 'haru_content'];
$post_types = get_post_types(['public' => true], 'names');
if (is_array($post_types)) {
    $post_types = array_diff($post_types, $exclude_posts);
}

$exclude_taxonomies = ['post_tag', 'post_format', 'product_brand', 'product_tag', 'product_shipping_class', 'wcdp-design-cat'];
$taxonomies = get_taxonomies(['public' => true], 'names');
if (is_array($taxonomies)) {
    $taxonomies = array_diff($taxonomies, $exclude_taxonomies);
}
?>

<div class="wrap">
    <h1><?php esc_html_e('Meta Checker', 'meta-checker'); ?></h1>
    <p><?php esc_html_e('This plugin checks and displays meta information of the current page.', 'meta-checker'); ?></p>


    <h1>Published Pages</h1>
    <p>
        <?php
        foreach ($post_types as $post_type) {
            $count = wp_count_posts($post_type)->publish;
            echo "<span>$post_type: $count, </span>";
        }
        ?>
    </p>

    <div class="table-container">
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Post Type</th>
                    <th>Meta Title</th>
                    <th>Meta Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($post_types as $post_type): ?>
                    <?php
                    $args = [
                        'post_type' => $post_type,
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    ];
                    $posts = get_posts($args);
                    ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><a target="_blank" href="<?= get_edit_post_link(esc_html($post->ID)) ?>"><?php echo esc_html($post->ID); ?></a></td>
                            <td><?php echo esc_html($post->post_title); ?></td>
                            <td><a target="_blank" href="<?= get_permalink($post->ID) ?>"><?= str_replace(home_url(), '', get_permalink($post->ID)) ?></a></td>
                            <td><?php echo esc_html($post->post_type); ?></td>
                            <td><span class="meta-title" data-link="<?= get_permalink($post->ID) ?>"></span></td>
                            <td><span class="meta-desc" data-link="<?= get_permalink($post->ID) ?>"></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h1>Taxonomies</h1>
    <div class="table-container">
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Meta Title</th>
                    <th>Meta Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taxonomies as $taxonomy): ?>
                    <?php
                    $terms = get_terms([
                        'taxonomy' => $taxonomy,
                        'hide_empty' => false,
                    ]);
                    ?>
                    <?php foreach ($terms as $term): ?>
                        <tr>
                            <td><a target="_blank" href="<?= get_edit_term_link(esc_html($term->term_id)) ?>"></a><?php echo esc_html($term->term_id); ?></td>
                            <td><?php echo esc_html($term->name); ?></td>
                            <td><a target="_blank" href="<?= get_term_link($term) ?>"><?= esc_html($term->slug) ?></a></td>
                            <td><span class="meta-title" data-link="<?= get_term_link($term) ?>"></span></td>
                            <td><span class="meta-desc" data-link="<?= get_term_link($term) ?>"></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>