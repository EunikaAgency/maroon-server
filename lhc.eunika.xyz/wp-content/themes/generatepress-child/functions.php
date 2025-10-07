<?php


require_once get_stylesheet_directory() . '/custom-functions.php';
// ----------------------------------------------------------------------------------------------------------------

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('fa5', wp_upload_dir()['baseurl'] . '/assets/adminlte/plugins/fontawesome-free/css/all.css', [], time());

  wp_enqueue_script('bs-js', wp_upload_dir()['baseurl'] . '/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.js', ['jquery'], time());
});

// ----------------------------------------------------------------------------------------------------------------

function get_menu() {
  if (isset($_COOKIE['debugger'])) {
    $menu = array_reverse(wp_get_nav_menu_items('primary'));

    $items = [];

    foreach ($menu as $key => $item) {
      if ($menu[$key + 1] == $item->menu_item_parent) {
      }
    }
  }
}


// ----------------------------------------------------------------------------------------------------------------


// Register Custom Post Type

function create_service_pages_post_type() {
  $labels = array(
    'name'                  => _x('Service Pages', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Service Page', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Service Pages', 'text_domain'),
    'name_admin_bar'        => __('Service Page', 'text_domain'),
    'archives'              => __('Service Page Archives', 'text_domain'),
    'attributes'            => __('Service Page Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Service Page:', 'text_domain'),
    'all_items'             => __('All Service Pages', 'text_domain'),
    'add_new_item'          => __('Add New Service Page', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Service Page', 'text_domain'),
    'edit_item'             => __('Edit Service Page', 'text_domain'),
    'update_item'           => __('Update Service Page', 'text_domain'),
    'view_item'             => __('View Service Page', 'text_domain'),
    'view_items'            => __('View Service Pages', 'text_domain'),
    'search_items'          => __('Search Service Pages', 'text_domain'),
    'not_found'             => __('Not found', 'text_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
    'featured_image'        => __('Featured Image', 'text_domain'),
    'set_featured_image'    => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image'    => __('Use as featured image', 'text_domain'),
    'insert_into_item'      => __('Insert into service page', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this service page', 'text_domain'),
    'items_list'            => __('Service pages list', 'text_domain'),
    'items_list_navigation' => __('Service pages list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter service pages list', 'text_domain'),
  );
  $args = array(
    'label'                 => __('Service Page', 'text_domain'),
    'description'           => __('Post Type Description', 'text_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
    'taxonomies'            => array('category', 'post_tag'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-admin-page',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'show_in_rest'          => true,
    'capability_type'       => 'page',
  );
  register_post_type('service-pages', $args);
}
add_action('init', 'create_service_pages_post_type', 0);

// ----------------------------------------------------------------------------------------------------------------

function create_location_pages_post_type() {
  $labels = array(
    'name'                  => _x('Location Pages', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Location Page', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Location Pages', 'text_domain'),
    'name_admin_bar'        => __('Location Page', 'text_domain'),
    'archives'              => __('Location Page Archives', 'text_domain'),
    'attributes'            => __('Location Page Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Location Page:', 'text_domain'),
    'all_items'             => __('All Location Pages', 'text_domain'),
    'add_new_item'          => __('Add New Location Page', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Location Page', 'text_domain'),
    'edit_item'             => __('Edit Location Page', 'text_domain'),
    'update_item'           => __('Update Location Page', 'text_domain'),
    'view_item'             => __('View Location Page', 'text_domain'),
    'view_items'            => __('View Location Pages', 'text_domain'),
    'search_items'          => __('Search Location Pages', 'text_domain'),
    'not_found'             => __('Not found', 'text_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
    'featured_image'        => __('Featured Image', 'text_domain'),
    'set_featured_image'    => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image'    => __('Use as featured image', 'text_domain'),
    'insert_into_item'      => __('Insert into location page', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this location page', 'text_domain'),
    'items_list'            => __('Location pages list', 'text_domain'),
    'items_list_navigation' => __('Location pages list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter location pages list', 'text_domain'),
  );
  $args = array(
    'label'                 => __('Location Page', 'text_domain'),
    'description'           => __('Post Type Description', 'text_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
    'taxonomies'            => array('category', 'post_tag'),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-location',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'show_in_rest'          => true,
    'capability_type'       => 'page',
    'rewrite'               => false
  );
  register_post_type('location', $args);
}
add_action('init', 'create_location_pages_post_type', 0);

// ----------------------------------------------------------------------------------------------------------------

add_shortcode('sc_related_services', function ($attrs) {
  ob_start();
  get_template_part('blocks/sample', '', $attrs);
  $content = ob_get_clean();

  if (!is_admin()) {
    return $content;
  }
});
// ----------------------------------------------------------------------------------------------------------------

add_shortcode('get_blocks', function ($attrs) {
  ob_start();
  get_template_part('blocks/post-list', '', $attrs);
  $content = ob_get_clean();

  if (!is_admin()) {
    return $content;
  }
});

// ----------------------------------------------------------------------------------------------------------------

add_shortcode('sc_banner_breadcrumbs', function ($attrs) {

  $type = 'page';

  if (isset($attrs['type'])) {
    $type = $attrs['type'];
  }

  $breadcrumbs = ["<li><a href='" . home_url() . "'>Home</a></li>"];

  if ($attrs['type'] == 'blog') {
    $category = get_the_category()[0];
    if ($category) {
      $breadcrumbs[] = "<li><a href='" . home_url($category->slug) . "'>" . $category->name . "</a></li>";
    }
  }

  $breadcrumbs[] = "<li>" . get_the_title() . "</li>";

  $content = "<ul class='banner-breadcrumbs m-0'>" . implode('&nbsp;/&nbsp;', $breadcrumbs) . "</ul>";

  if (!is_admin()) {
    return $content;
  }
});

// ----------------------------------------------------------------------------------------------------------------



add_shortcode('sc_same_categories', function ($attrs) {

  $categories = get_the_category();
  $category_ids = [];

  foreach ($categories as $category) {
    $category_ids[] = $category->term_id;
  }

  $args = array(
    'category'      => $category_ids,
    'numberposts' => 10,
    'post_type' => 'post',
    'post_status' => 'publish'
  );
  $posts = get_posts($args);
  $post_list = [];

  foreach ($posts as $post) {
    if (!isset($post_list[$post->ID])) {
      $post_list[$post->ID] = '<li class="same-categories-list"><a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></li>';
    }
  }

  $content = '<ul class="sc-same-categories">' . implode('', $post_list) . '</ul>';

  if (!is_admin()) {
    return $content;
  }
});


// ----------------------------------------------------------------------------------------------------------------

add_shortcode('sc_category_list', function ($attrs) {

  $categories = get_categories();
  $category_list = [];

  foreach ($categories as $category) {
    $args = array(
      'category' => $category->term_id,
      'numberposts' => -1,
      'post_type' => 'post',
      'post_status' => 'publish'
    );

    $c_count = count(get_posts($args));
    $category_list[] = '<li><a href=' . home_url('category/' . $category->slug) . '><span>' . $category->name . '</span><span>(' . $c_count . ')</span></a></li>';
  }

  $content = '<ul class="sc-category-list">' . implode('', $category_list) . '</ul>';

  if (!is_admin()) {
    return $content;
  }
});

// -----------------------------------------------------------------------------------------------------------------
function recent_posts_shortcode($atts) {
  $display = isset($atts['display']) ? $atts['display'] : 'default';
  $limit = isset($atts['limit']) ? $atts['limit'] : 10;
  $recent_posts = wp_get_recent_posts(['numberposts' => $limit, 'post_status' => 'publish']);
  $output = '';

  if ($recent_posts) {

    if ($display == 'card') {
      ob_start();
      get_template_part('blocks/popular-post', null, ['posts' => $recent_posts]);
      $output = ob_get_clean();
    } else {

      $output = '<ul class="recent-posts-list">';
      foreach ($recent_posts as $post) {
        $title = $post['post_title'];
        $url = get_permalink($post['ID']);
        $output .= "<li><a href='$url'>$title</a></li>";
      }
      $output .= '</ul>';
    }
  } else {
    $output = 'No posts found';
  }

  if (!is_admin()) {
    return $output;
  }
}
add_shortcode('recent_posts', 'recent_posts_shortcode');

// -----------------------------------------------------------------------------------------------------------------
function custom_search_form_shortcode() {
  ob_start(); ?>

  <div class="bg-slate">
    <form class="post-search" action="<?= home_url() ?>" method="get">
      <input type="text" name="s" placeholder="Search Keywords">
      <button class="bg-green">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>

<?php
  return ob_get_clean();
}
add_shortcode('custom_search_form', 'custom_search_form_shortcode');


add_shortcode('partials', function ($attr) {

  if (isset($attr['filename'])) {

    ob_start();
    get_template_part($attr['filename']);
    $content = ob_get_clean();

    if (!is_admin()) {
      return $content;
    }
  }

  return;
});


add_action('wp', function () {
  $site_reviews = get_option('site_reviews', null);

  if ($site_reviews == null) {
    add_option('site_reviews', []);
  }
});



function containsSuspiciousPattern($input) {
  $suspiciousPatterns = [
    '/{{.*?}}/',
    '/#\{.*?\}=/',
    '/{{{.*?}}}/',
    '/{{".*?"\|.*?}}/',
    '/[\p{Cyrillic}]/u'
  ];

  foreach ($suspiciousPatterns as $pattern) {
    if (preg_match($pattern, $input)) {
      return true;
    }
  }

  $domains = [
    '.ru' => -3,
  ];

  if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
    foreach ($domains as $domain => $length) {
      if (substr($input, $length) == $domain) {
        return true;
      }
    }
  }

  return false;
}

add_action('wpforms_process', function ($fields, $entry, $form_data) {
  foreach ($fields as $field_id => $field) {
    $value = $field['value'];
    if (containsSuspiciousPattern($value)) {
      wpforms()->process->errors[$form_data['id']][$field_id] = esc_html__('Access denied.', 'wpforms');
      return;
    }
  }
}, 10, 3);


// ----------------------------------------------------------------------------------------------------------------

