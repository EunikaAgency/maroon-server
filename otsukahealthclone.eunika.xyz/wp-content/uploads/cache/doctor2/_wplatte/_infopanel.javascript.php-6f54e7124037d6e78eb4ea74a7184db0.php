<?php //netteCache[01]000600a:2:{s:4:"time";s:21:"0.65734700 1752475520";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:112:"/var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/infopanel/javascript.php";i:2;i:1752474530;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/infopanel/javascript.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'ka4aea3oai')
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
jQuery(window).load(function(){
<?php if ($options->theme->general->progressivePageLoading) { ?>
		if(!isResponsive(1024)){
			jQuery("#<?php echo $htmlId ?>-main").waypoint(function(){
				jQuery("#<?php echo $htmlId ?>-main").addClass('load-finished');
			}, { triggerOnce: true, offset: "95%" });
		} else {
			jQuery("#<?php echo $htmlId ?>-main").addClass('load-finished');
		}
<?php } else { ?>
		jQuery("#<?php echo $htmlId ?>-main").addClass('load-finished');
<?php } ?>
});

jQuery(document).ready(function(){
	jQuery("#<?php echo $htmlId ?>-main .tabs-container a").click(function(e){
		e.preventDefault();
		jQuery("#<?php echo $htmlId ?>-main .tabs-container li").removeClass('active');
		jQuery("#<?php echo $htmlId ?>-main .panel-container").removeClass('panel-active');
		jQuery(this).parent().addClass('active');
		jQuery("#"+jQuery(this).data('panel')).addClass('panel-active');

		if(isResponsive(640)){
			var $li = jQuery(this).parent();
			jQuery("#<?php echo $htmlId ?>-main .tabs-container ul").prepend($li);
			jQuery("#<?php echo $htmlId ?>-main .tabs-container ul").addClass('elements-unsorted');	
		}
	});
	
	if(isResponsive(640)){
		var tabs = jQuery("#<?php echo $htmlId ?>-main .tabs-container");

		if(!isMobile()) {
			tabs.mouseenter(function(){
				tabs.addClass('hover');
			})
			.mouseleave(function(){
				tabs.removeClass('hover');
			});
		} else {
			tabs.click(function(){
				jQuery(this).toggleClass("hover");
			});
		}
	}
	
});

jQuery(window).resize(function(){
	// reset the tabs order
	if(isResponsive(640) == false){
		var $container = jQuery("#<?php echo $htmlId ?>-main ul.elements-unsorted");
		var $tabs = $container.children('li');
		$tabs.sort(function(a, b){
			var ao = parseInt(jQuery(a).data("order"));
			var bo = parseInt(jQuery(b).data("order"));

			if(ao > bo) {
				return 1;
			}
			if(ao < bo) {
				return -1;
			}
			return 0;
		});
		$tabs.detach().appendTo($container);
		$container.removeClass('elements-unsorted');
	} else {
		jQuery("#<?php echo $htmlId ?>-main .tabs-container ul").prepend(jQuery("#<?php echo $htmlId ?>-main .tabs-container li.active"));
		jQuery("#<?php echo $htmlId ?>-main .tabs-container ul").addClass('elements-unsorted');
	}
});
	 

</script>