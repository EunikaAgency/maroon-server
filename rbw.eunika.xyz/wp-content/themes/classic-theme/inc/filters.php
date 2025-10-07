<?php

function add_webp_upload_mimes($mime_types) {
    $mime_types['webp'] = 'image/webp';
    return $mime_types;
}
add_filter('upload_mimes', 'add_webp_upload_mimes');

function enable_webp_display($result, $path) {
    $info = getimagesize($path);
    $mime = $info['mime'];
    if ($mime === 'image/webp') {
        $result = true;
    }
    return $result;
}
add_filter('file_is_displayable_image', 'enable_webp_display', 10, 2);