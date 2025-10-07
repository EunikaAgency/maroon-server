<?php

// Codedropz API url
$api_url = 'https://api.codedropz.com/wc-api-remote/index.php';

// Plugin Slug
$plugin_slug = 'drag-and-drop-file-uploads-wc-pro';

// Plugin Name
$plugin_name = 'Drag and Drop Multiple File Upload (Pro) - WooCommerce';

// Cache Key - added
$cache_key = 'drag_and_drop_wc_remote_api_request_' . md5( $plugin_slug );

// Take over the Plugin info screen
add_filter('plugins_api', 'drag_n_drop_file_upload_wc_api_update_call', 10, 3);

function drag_n_drop_file_upload_wc_api_update_call( $res, $action, $args ) {
	global $plugin_slug, $api_url, $wp_version, $plugin_name, $cache_key;

	// Do nothing if this is not about getting plugin information
	if( $action !== 'plugin_information' ) {
		return false;
	}

	// Dont proceed if it's not our plugin
	if ( isset( $args->slug ) && ( $args->slug != $plugin_slug ) ) {
		return $res;
	}

	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = DNDMFU_WC_PRO_VERSION;

	// Versioning and Plugin name
	$args->version = $current_version;
	$args->name = $plugin_name;

    // Get transient data - Added
	$api_request_transient = get_site_transient( $cache_key );

    // If transient is empty - request update in api
    if( empty( $api_request_transient ) ){

        // Setup query string Args
        $request_string = array(
            'body' => array(
                'action' => $action,
                'request' => serialize($args),
                'api-key' => md5( get_bloginfo('url') )
            ),
            'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
        );

        // Request file to API
        $request = wp_remote_post( $api_url, $request_string );

        if ( is_wp_error( $request ) ) {
            $res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
        } else {
            $res = unserialize( $request['body'] );
            if( $res === false ) {
                $res = new WP_Error( 'plugins_api_failed', __('An unknown error occurred'), $request['body'] );
            }else{
                set_site_transient( $cache_key, $res, DAY_IN_SECONDS ); //expires 1 day
            }
        }

        return $res;

    }

    // Get data from transient
    $res = $api_request_transient;

	return $res;
}

// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'drag_n_drop_file_wc_upload_update_checker');

function drag_n_drop_file_wc_upload_update_checker($checked_data) {
	global $api_url, $plugin_slug, $wp_version;

	$response = '';

    // bail early if no response (error)
    if( ! isset($checked_data->response) ) {
        return $checked_data;
    }

	//Comment out these two lines during testing.
	if ( empty( $checked_data->checked ) || ! isset( $checked_data->checked[ $plugin_slug .'/drag-and-drop-file-uploads-wc-pro.php'] ) ) {
		return $checked_data;
	}

	$args = array(
		'slug' => $plugin_slug,
		'version' => DNDMFU_WC_PRO_VERSION,
	);

	$request_string = array(
		'body' => array(
			'action' => 'basic_check',
			'request' => serialize( $args ),
			'api-key' => md5(get_bloginfo('url'))
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	// Start checking for an update
	$raw_response = wp_remote_post( $api_url, $request_string );

	if ( ! is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) ){
		$response = unserialize( $raw_response['body'] );
	}

	if ( is_object( $response ) && ! empty( $response ) ) {
        if( isset( $response->no_update ) && $response->no_update ) {
			$checked_data->no_update[ $plugin_slug .'/drag-and-drop-file-uploads-wc-pro.php'] = $response;
		}else {
			$checked_data->response[ $plugin_slug .'/drag-and-drop-file-uploads-wc-pro.php'] = $response;
		}
	}

	$checked_data->last_checked = time();
	$checked_data->checked[ $plugin_slug .'/drag-and-drop-file-uploads-wc-pro.php' ] = DNDMFU_WC_PRO_VERSION;

	return $checked_data;
}