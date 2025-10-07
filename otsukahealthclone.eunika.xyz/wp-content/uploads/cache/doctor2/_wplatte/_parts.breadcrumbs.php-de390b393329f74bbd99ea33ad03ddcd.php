<?php //netteCache[01]000577a:2:{s:4:"time";s:21:"0.63058000 1752475520";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:90:"/var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/parts/breadcrumbs.php";i:2;i:1752474530;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/parts/breadcrumbs.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '1ouilr9kma')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($options->layout->general->showBreadcrumbs) { ?>
<div class="breadcrumb">
	<div class="grid-main">
		<?php echo WpLatteMacros::breadcrumbs(array($options->theme->breadcrumbs)) ?>

		<div class="search">
<?php get_search_form() ?>
		</div>	
	</div>
</div>
<?php } 