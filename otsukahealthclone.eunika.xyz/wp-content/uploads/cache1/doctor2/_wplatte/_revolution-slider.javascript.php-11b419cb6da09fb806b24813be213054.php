<?php //netteCache[01]000619a:2:{s:4:"time";s:21:"0.37034100 1644572349";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:131:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/revolution-slider/javascript.php";i:2;i:1644561066;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/revolution-slider/javascript.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'c23rvnht28')
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
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-script">
jQuery(document).ready(function(){
	if(isResponsive(parseInt(<?php echo NTemplateHelpers::escapeJs($el->option('responsive')) ?>))){
		jQuery('#<?php echo $htmlId ?> .slider').addClass('reloadMe');
	}
});

jQuery(window).load(function(){
	if(isResponsive(parseInt(<?php echo NTemplateHelpers::escapeJs($el->option('responsive')) ?>))){
		if(jQuery('#<?php echo $htmlId ?> .slider-alternative').children('img').attr('src') != ""){
			jQuery('#<?php echo $htmlId ?> .slider').hide();
			jQuery('#<?php echo $htmlId ?> .slider-alternative').show();
		} else {
			jQuery('#<?php echo $htmlId ?> .slider').show();
			jQuery('#<?php echo $htmlId ?> .slider-alternative').hide();
		}
	} else {
		jQuery('#<?php echo $htmlId ?> .slider').show();
		jQuery('#<?php echo $htmlId ?> .slider-alternative').hide();
		if(jQuery('#<?php echo $htmlId ?> .slider').hasClass('reloadMe')){
			jQuery('#<?php echo $htmlId ?> .slider').removeClass('reloadMe');
			location.reload();
		}
	}
});

jQuery(window).resize(function(){
	if(isResponsive(parseInt(<?php echo NTemplateHelpers::escapeJs($el->option('responsive')) ?>))){
		if(jQuery('#<?php echo $htmlId ?> .slider-alternative').children('img').attr('src') != ""){
			jQuery('#<?php echo $htmlId ?> .slider').hide();
			jQuery('#<?php echo $htmlId ?> .slider-alternative').show();
		} else {
			jQuery('#<?php echo $htmlId ?> .slider').show();
			jQuery('#<?php echo $htmlId ?> .slider-alternative').hide();
		}
	} else {
		jQuery('#<?php echo $htmlId ?> .slider').show();
		jQuery('#<?php echo $htmlId ?> .slider-alternative').hide();
		if(jQuery('#<?php echo $htmlId ?> .slider').hasClass('reloadMe')){
			jQuery('#<?php echo $htmlId ?> .slider').removeClass('reloadMe');
			location.reload();
		}
	}
});
</script>
