<?php //netteCache[01]000628a:2:{s:4:"time";s:21:"0.35322700 1644572349";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:140:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/revolution-slider/revolution-slider.latte";i:2;i:1644558007;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/revolution-slider/revolution-slider.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '2mt4kt7b94')
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
<!-- SLIDER -->
<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>
 <?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>">

	<!--<div class="loading"><span class="ait-preloader"><?php echo __('Loading&hellip;', 'wplatte') ?></span></div>-->

	<div class="slider">
		<?php echo $el->renderSlider() ?>

	</div>
<?php if ($el->option('alternative') != '') { ?>
	<div class="slider-alternative" style="display: none">
		<img src="<?php echo NTemplateHelpers::escapeHtml($el->option('alternative'), ENT_COMPAT) ?>" alt="alternative" />
	</div>
<?php } ?>

</div><!-- end of slider -->

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/revolution-slider/javascript", ""), array() + get_defined_vars(), $_l->templates['2mt4kt7b94'])->render() ;