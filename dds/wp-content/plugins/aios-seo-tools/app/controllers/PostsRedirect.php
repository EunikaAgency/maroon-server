<?php
/**
 * Usage: Redirect post depending category
 */
namespace AiosSeoTools\App\Controllers;

use AiosSeoTools\Config\Options;

class PostsRedirect
{
  use Options;

  /**
   * PostsRedirect constructor.
   *
   * @since 1.4.5
   */
  public function __construct()
  {
    $options = $this->options();
    if ($options['wordpress_redirect'] === '1') {
      add_action('template_redirect', [$this, 'post_redirect_by_custom_filters']);
    }
  }

  /**
   * Redirect Posts to It's category
   *
   * @since 1.4.5
   */
  public function post_redirect_by_custom_filters()
  {
    // Check if page is 404
    // If we do not check if is 404 we might redirect a existing page or custom post type
    if (is_404()) {
      global $wp;

      // then check if the request slug is exists then redirect
      $queried_post = get_page_by_path($wp->request,OBJECT,'post');
      if ($queried_post) {
        wp_redirect(get_permalink($queried_post), 301);
        exit;
      }
    }
  }
}

new PostsRedirect();
