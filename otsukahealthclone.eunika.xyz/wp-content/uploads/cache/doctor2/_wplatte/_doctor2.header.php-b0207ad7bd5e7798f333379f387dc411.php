<?php //netteCache[01]000566a:2:{s:4:"time";s:21:"0.50475300 1752475520";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:79:"/var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/header.php";i:2;i:1752474530;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/header.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 't4p38y5gv8')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<!doctype html>
<!--[if IE 8]>
<html <?php language_attributes() ?>  class="lang-<?php echo NTemplateHelpers::escapeHtmlComment($currentLang->locale) ?>
 <?php echo NTemplateHelpers::escapeHtmlComment($options->layout->custom->pageHtmlClass) ?> ie ie8">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)]><!-->
<html <?php language_attributes() ?> class="lang-<?php echo NTemplateHelpers::escapeHtml($currentLang->locale, ENT_COMPAT) ?>
 <?php echo NTemplateHelpers::escapeHtml($options->layout->custom->pageHtmlClass, ENT_COMPAT) ?>">
<!--<![endif]-->
<head>
	<meta charset="<?php echo NTemplateHelpers::escapeHtml($wp->charset, ENT_COMPAT) ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php echo NTemplateHelpers::escapeHtml($wp->pingbackUrl, ENT_COMPAT) ?>" />

<?php if ($options->theme->general->favicon != "") { ?>
		<link href="<?php echo NTemplateHelpers::escapeHtml($options->theme->general->favicon, ENT_COMPAT) ?>" rel="icon" type="image/x-icon" />
<?php } ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/seo", ""), array() + get_defined_vars(), $_l->templates['t4p38y5gv8'])->render() ?>

	<?php echo AitWpLatteMacros::googleAnalytics($options->theme->google->analyticsTrackingId, $options->theme->google->anonymizeIp) ?>


	<?php echo $options->theme->header->customJsCode ?>


	<!--[if lt IE 9]>
	<script>
	document.createElement('header');
	document.createElement('nav');
	document.createElement('section');
	document.createElement('article');
	document.createElement('aside');
	document.createElement('footer');
	document.createElement('hgroup');
	</script>
	<![endif]-->

	<?php wp_head() ?> 
</head>
<body <?php echo $wp->bodyHtmlClass ?>>
<?php do_action('ait-html-body-begin') ?>

	<div id="page" class="hfeed page-container">

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/header-share", ""), array('showShare' => $options->theme->header->headerShare) + get_defined_vars(), $_l->templates['t4p38y5gv8'])->render() ?>

			<header id="masthead" class="site-header" role="banner">
				<div class="header-container grid-main">
					<div class="site-logo">
<?php if ($options->theme->header->logo) { ?>
						<a href="<?php echo NTemplateHelpers::escapeHtml($homeUrl, ENT_COMPAT) ?>" title="<?php echo $wp->name ?>
" rel="home"><img src="<?php echo NTemplateHelpers::escapeHtml($options->theme->header->logo, ENT_COMPAT) ?>" alt="logo" /></a>
<?php } else { ?>
						<div class="site-title"><a href="<?php echo NTemplateHelpers::escapeHtml($homeUrl, ENT_COMPAT) ?>
" title="<?php echo $wp->name ?>" rel="home"><?php echo $wp->name ?></a></div>
<?php } ?>
					</div>

					<div class="site-tools">

						<div class="menu-container">
							<nav class="main-nav" role="navigation">
								<div class="main-nav-wrap">
									<h3 class="menu-toggle"><?php echo NTemplateHelpers::escapeHtml(__('Menu', 'wplatte'), ENT_NOQUOTES) ?></h3>
<?php WpLatteMacros::menu("main", array()) ?>
								</div>
							</nav>
						</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/social-icons", ""), array() + get_defined_vars(), $_l->templates['t4p38y5gv8'])->render() ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/languages-switcher", ""), array() + get_defined_vars(), $_l->templates['t4p38y5gv8'])->render() ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/woocommerce-cart", ""), array() + get_defined_vars(), $_l->templates['t4p38y5gv8'])->render() ?>
					</div>

				</div>
			</header><!-- #masthead -->


		<div class="sticky-menu menu-container" >
			<div class="grid-main">
				<div class="site-logo">
<?php if ($options->theme->header->logo) { ?>
					<a href="<?php echo NTemplateHelpers::escapeHtml($homeUrl, ENT_COMPAT) ?>" title="<?php echo $wp->name ?>
" rel="home"><img src="<?php echo NTemplateHelpers::escapeHtml($options->theme->header->logo, ENT_COMPAT) ?>" alt="logo" /></a>
<?php } else { ?>
					<div class="site-title"><a href="<?php echo NTemplateHelpers::escapeHtml($homeUrl, ENT_COMPAT) ?>
" title="<?php echo $wp->name ?>" rel="home"><?php echo $wp->name ?></a></div>
<?php } ?>
				</div>
				<nav class="main-nav">
					<!-- wp menu here -->
				</nav>
			</div>
		</div>
