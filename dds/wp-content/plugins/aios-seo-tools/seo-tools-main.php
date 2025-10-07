<?php
/**
 * Plugin Name: AIOS SEO Tools
 * Description: Site verification for bing and google. To standardized google analytics and contact form 7 goals tracker.
 * Version: 2.0.5
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */

namespace AiosSeoTools;

if (! defined('SEOTOOLS_SETUP_URL')) define('SEOTOOLS_SETUP_URL', plugin_dir_url(__FILE__));
if (! defined('SEOTOOLS_SETUP_DIR')) define('SEOTOOLS_SETUP_DIR', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR);
if (! defined('SEOTOOLS_SETUP_RESOURCES')) define('SEOTOOLS_SETUP_RESOURCES', SEOTOOLS_SETUP_URL . 'resources/');
if (! defined('SEOTOOLS_SETUP_VIEWS')) define('SEOTOOLS_SETUP_VIEWS', SEOTOOLS_SETUP_DIR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

require 'FileLoader.php';

$fileLoader = new FileLoader();
$fileLoader->load_files([
  'config/Config',
  'config/Options',
  'app/App'
]);

// Load App
new App\App(__FILE__);

// Load Controllers
$fileLoader->load_directory('app/controllers');
