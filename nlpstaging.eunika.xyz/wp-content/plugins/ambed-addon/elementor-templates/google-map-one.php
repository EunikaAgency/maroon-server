<?php
if (empty($settings['address'])) {
	return;
}

if (0 === absint($settings['zoom']['size'])) {
	$settings['zoom']['size'] = 10;
}

$api_key = esc_html(get_option('elementor_google_maps_api_key'));

$params = [
	rawurlencode($settings['address']),
	absint($settings['zoom']['size']),
];

if ($api_key) {
	$params[] = $api_key;

	$url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
} else {
	$url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
}

?>
<div class="elementor-custom-embed">
	<iframe src="<?php echo esc_url(vsprintf($url, $params)); ?>" title="<?php echo esc_attr($settings['address']); ?>" aria-label="<?php echo esc_attr($settings['address']); ?>"></iframe>
</div>