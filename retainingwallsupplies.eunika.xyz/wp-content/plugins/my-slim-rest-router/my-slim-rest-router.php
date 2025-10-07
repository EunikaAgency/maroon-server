<?php
/**
 * Plugin Name: Slim REST Router
 * Description: Simple REST API router using /wp-json/controller/function.
 * Version: 1.0
 * Author: Eunika
 */

defined('ABSPATH') || exit;

define('MY_API_CONTROLLERS_DIR', plugin_dir_path(__FILE__) . 'controllers/');

add_action('rest_api_init', function () {
    register_rest_route('custom', '/(?P<controller>[a-zA-Z0-9_-]+)/(?P<function>[a-zA-Z0-9_-]+)', [
        'methods'             => ['GET', 'POST'],
        'callback'            => 'my_slim_rest_router',
        'permission_callback' => '__return_true',
    ]);
});


function my_slim_rest_router($request) {
    $controller_slug = sanitize_text_field($request['controller']);
    $function_name   = sanitize_text_field($request['function']);

    $class_name = ucfirst($controller_slug) . 'Controller';
    $file_path  = MY_API_CONTROLLERS_DIR . $class_name . '.php';

    if (!file_exists($file_path)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => "Controller file '{$class_name}.php' not found."
        ], 404);
    }

    require_once $file_path;

    if (!class_exists($class_name)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => "Class '{$class_name}' not found in controller file."
        ], 404);
    }

    $controller = new $class_name();

    if (!method_exists($controller, $function_name)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => "Method '{$function_name}' not found in class '{$class_name}'."
        ], 404);
    }

    return call_user_func([$controller, $function_name], $request);
}


