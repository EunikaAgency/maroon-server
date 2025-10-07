<?php

namespace AiosSeoTools\Config;

trait Config {

  /**
   * Tabs
   *
   * @return array
   */
  protected function tabs() {
    $tabs = [
      '' => [
        'url' => 'google',
        'title' => 'Google',
        'child' => [
          [
            'url' => 'services',
            'title' => 'Services',
            'function' => 'google/services.php'
          ],
          [
            'url' => 'search-console',
            'title' => 'Search Console',
            'function' => 'google/search-console.php'
          ],
          [
            'url' => 'analytics',
            'title' => 'Analytics',
            'function' => 'google/analytics.php'
          ],
          [
            'url' => 'analytics-4-properties',
            'title' => 'Analytics 4 Properties',
            'function' => 'google/analytics-4-properties.php'
          ],
          [
            'url' => 'tag-manager',
            'title' => 'Tag Manager',
            'function' => 'google/tag-manager.php'
          ],
          [
            'url' => 'adwords-tag-manager',
            'title' => 'AdWords Tag Manager',
            'function' => 'google/adwords-tag-manager.php'
          ]
        ]
      ],
      'bing' => [
        'url' => 'bing',
        'title' => 'Bing',
        'function' => 'bing/bing.php'
      ],
      'schema-markup' => [
        'url' => 'schema-markup',
        'title' => 'Schema Markup',
        'child' => [
          [
            'url' => 'basic',
            'title' => 'Basic',
            'function' => 'rich-snippet/basic.php'
          ],
          [
            'url' => 'map',
            'title' => 'Map',
            'function' => 'rich-snippet/map.php'
          ],
          [
            'url' => 'open-hours',
            'title' => 'Open Hours',
            'function' => 'rich-snippet/open-hours.php'
          ]
        ]
      ],
      'facebook' => [
        'url' => 'facebook',
        'title' => 'Facebook',
        'function' => 'facebook/pixel.php'
      ],
      'wordpress' => [
        'url' => 'wordpress',
        'title' => 'WordPress',
        'function' => 'wordpress/index.php'
      ],
    ];

    return array_filter($tabs);
  }
}
