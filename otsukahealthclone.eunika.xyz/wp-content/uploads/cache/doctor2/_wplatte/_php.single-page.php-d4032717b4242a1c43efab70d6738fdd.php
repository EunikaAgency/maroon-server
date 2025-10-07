<?php //netteCache[01]000595a:2:{s:4:"time";s:21:"0.34613600 1652944915";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:107:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/plugins/slide-anything/php/single-page.php";i:2;i:1644561061;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/plugins/slide-anything/php/single-page.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '7uuleqodz8')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//

/**
 * Template Name: Slide Anything Preview Page
 * This template will only display the page content (and no header, footer or sidebar)
 */
?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head() ?>
</head>
<body class="cleanpage">
<?php
	while (have_posts()) : the_post();  
		the_content();
	endwhile;




wp_footer() ?>
</body>
</html>