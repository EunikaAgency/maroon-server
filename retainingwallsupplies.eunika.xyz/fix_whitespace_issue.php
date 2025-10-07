<?php
function learn2smart_fix_wp_whitespace_issue($input) {

$allowed = false;
$found = false;

foreach (headers_list() as $header) {

    if (preg_match("/^content-type:\s+(text\/(html|application\/(xhtml\+xml|atom\+xml|xml)))/i", $header)) {
        $allowed = true;
    }

    if (preg_match("/^content-type:\s+/i", $header)) {
        $found = true;
    }
}

if ($allowed || $found) {
    return preg_replace("/^\s*/m", "", $input);
} else {
    return $input;
}
}

ob_start("learn2smart_fix_wp_whitespace_issue");
?>