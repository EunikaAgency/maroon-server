<?php //netteCache[01]000598a:2:{s:4:"time";s:21:"0.01508700 1752479106";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:110:"/var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/toggles/javascript.php";i:2;i:1752474530;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/toggles/javascript.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'wk9oml9x5n')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($el->option('type') == 'accordion') { ?>
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-script">
jQuery(function(){
	jQuery('#<?php echo $htmlId ?>').accordion({ heightStyle: "content" });

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
</script>
<?php } elseif ($el->option('type') == 'toggle') { ?>
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-script">
jQuery(function(){
	jQuery('#<?php echo $htmlId ?>').find('.toggle-content').css({'display':'none'});
	jQuery('#<?php echo $htmlId ?>').find('.toggle-header').each(function(){
		jQuery(this).prepend('<span class="ui-icon"></span>');
		jQuery(this).addClass('toggle-inactive');
		jQuery(this).click(function(){
			jQuery(this).next().slideToggle('fast', function(){
				jQuery(this).prev().toggleClass('toggle-inactive');
				jQuery(this).prev().toggleClass('toggle-active');
			});
		});
	});

<?php if ($options->theme->general->progressivePageLoading) { ?>
		if(!isResponsive(1024)){
			jQuery("#<?php echo $htmlId ?>").waypoint(function(){
				jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
			}, { triggerOnce: true, offset: "95%" });
		} else {
			jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
		}
<?php } else { ?>
		jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
<?php } ?>
});
</script>
<?php } elseif ($el->option('type') == 'htabs') { ?>
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-script">
jQuery(function(){
	jQuery('#<?php echo $htmlId ?>').tabs({
			beforeActivate: function(event, ui){
				ui.newPanel.children().hide();
			},
			activate: function(event, ui){
				ui.newPanel.children().not('.modal-wrap').fadeIn('slow');
			}
	}).addClass("ait-tabs-horizontal");

<?php if ($options->theme->general->progressivePageLoading) { ?>
		if(!isResponsive(1024)){
			jQuery("#<?php echo $htmlId ?>").waypoint(function(){
				jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
			}, { triggerOnce: true, offset: "95%" });
		} else {
			jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
		}
<?php } else { ?>
		jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
<?php } ?>
});
jQuery(window).load(function(){
	tabsWidth('#<?php echo $htmlId ?>', "ait-tabs-horizontal");
	responsiveTabs('#<?php echo $htmlId ?>', "ait-tabs-horizontal");
});
jQuery(window).resize(function(){
	responsiveTabs('#<?php echo $htmlId ?>', "ait-tabs-horizontal");
});

/* new functionality for responsive */
jQuery("#<?php echo $htmlId ?>").find('select.responsive-tabs-select').on('change', function(){
	var tabsContainer = jQuery("#<?php echo $htmlId ?>").find('ul:first');
	var $selected = jQuery(this).find('option:selected');
	tabsContainer.find('a[href="'+$selected.val()+'"]').trigger('click');
});
/* new functionality for responsive */
</script>
<?php } else { ?>
<script id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-script">
jQuery(function(){
	jQuery('#<?php echo $htmlId ?>').tabs({
		beforeActivate: function(event, ui){
				ui.newPanel.children().hide();
			},
			activate: function(event, ui){
				ui.newPanel.children().not('.modal-wrap').fadeIn('slow');
			}
	}).addClass("ait-tabs-vertical");
	jQuery('#<?php echo $htmlId ?> li').removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

<?php if ($options->theme->general->progressivePageLoading) { ?>
		if(!isResponsive(1024)){
			jQuery("#<?php echo $htmlId ?>").waypoint(function(){
				jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
			}, { triggerOnce: true, offset: "95%" });
		} else {
			jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
		}
<?php } else { ?>
		jQuery("#<?php echo $htmlId ?>").parent().parent().addClass('load-finished');
<?php } ?>
});
jQuery(window).load(function(){
	tabsWidth('#<?php echo $htmlId ?>', "ait-tabs-vertical");
	responsiveTabs('#<?php echo $htmlId ?>', "ait-tabs-vertical");

	tabsHover('#<?php echo $htmlId ?>', "ait-tabs-vertical");
});
jQuery(window).resize(function(){
	responsiveTabs('#<?php echo $htmlId ?>', "ait-tabs-vertical");
});

/* new functionality for responsive */
jQuery("#<?php echo $htmlId ?>").find('select.responsive-tabs-select').on('change', function(){
	var tabsContainer = jQuery("#<?php echo $htmlId ?>").find('ul:first');
	var $selected = jQuery(this).find('option:selected');
	tabsContainer.find('a[href="'+$selected.val()+'"]').trigger('click');
});
/* new functionality for responsive */
</script>
<?php } 