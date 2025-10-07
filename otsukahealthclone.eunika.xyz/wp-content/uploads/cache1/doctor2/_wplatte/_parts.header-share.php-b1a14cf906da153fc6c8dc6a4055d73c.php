<?php //netteCache[01]000590a:2:{s:4:"time";s:21:"0.32413900 1644572349";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:102:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/header-share.php";i:2;i:1644557990;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/header-share.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'y09msfp1y8')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$type = isset($elements->unsortable["page-title"]->option->type) ? $elements->unsortable["page-title"]->option->type : 'standard' ?>

<?php $shareUrl 				= "" ;$shareTitle 			= "" ;$shareImage 			= "" ;$shareDescription		= "" ?>

<?php if ($wp->isPage or $wp->isSingular('post') or $wp->isSingular('portfolio-item') or $wp->isSingular('event') or $wp->isSingular('job-offer') or $wp->isSingular('doc') or $wp->isSingular('theme')) { foreach($iterator = new WpLatteLoopIterator() as $post): $shareUrl 			= $post->permalink ;$shareTitle 		= $post->title ;$shareImage 		= isset($post->ID) ? wp_get_attachment_url(get_post_thumbnail_id($post->ID)) : wp_get_attachment_url(get_post_thumbnail_id($post->id)) ;$shareDescription	= substr(strip_tags($post->excerpt), 0, 100) ?>

<?php if ($type == 'theme' && $wp->isPage) { $query = WpLatteMacros::prepareCustomWpQuery(array('id' => $elements->unsortable["page-title"]->option->theme, 'type' => 'theme')); if ($query->havePosts) { foreach ($iterator = new WpLatteLoopIterator($query) as $item): $shareTitle 		= $item->meta('theme')->subtitle ;$shareDescription 	= strip_tags($item->content) ;$shareImage 		= $item->imageUrl ;endforeach; wp_reset_postdata(); } } ?>

<?php endforeach; } else { $qobj = get_queried_object() ;if ($qobj and isset($qobj->ID)) { $shareUrl 				= get_permalink($qobj->ID) ;$shareTitle 			= get_the_title($qobj->ID) ;$shareDescription		= '' ;} } ?>

<?php $SEOOptions = $elements->unsortable["seo"]->option ?>

<?php if (isset($SEOOptions->title) && $SEOOptions->title != "") { $shareTitle = $SEOOptions->title ;} if (isset($SEOOptions->description) && $SEOOptions->description != "") { $shareDescription 	= substr($SEOOptions->description, 0, 80) ;} if ($showShare == "enabled" and $shareUrl and $shareTitle) { ?>

<?php $socIconsEnabled = array() ;if ($options->theme->header->enableFacebook) { array_push($socIconsEnabled, 'facebook') ;} if ($options->theme->header->enableTwitter) { array_push($socIconsEnabled, 'twitter') ;} if ($options->theme->header->enableGooglePlus) { array_push($socIconsEnabled, 'google') ;} ?>

<div class="page-share">
	<div class="content">
<?php if ($wp->isWidgetAreaActive($options->theme->header->headerWidgetArea->sidebar)) { ?>
		<div class="share share-widgetarea">
			<div class="icon-content">
				<i class="fa fa-lightbulb-o"></i>
			</div>
			<div class="area-content">
<?php dynamic_sidebar($options->theme->header->headerWidgetArea->sidebar) ?>
			</div>
		</div>
<?php } ?>
		
<?php if (count($socIconsEnabled) > 0) { ?>
		<div class="share share-title">
			<span class="title-content"><?php echo NTemplateHelpers::escapeHtml(__('Share', 'wplatte'), ENT_NOQUOTES) ?></span>
		</div>
<?php } ?>

<?php if ($options->theme->header->enableFacebook) { ?>
		<div class="share share-basic share-facebook">
			<a href="#" onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareUrl ?>', '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<i class="fa fa-facebook"></i>
			</a>
		</div>
<?php } if ($options->theme->header->enableTwitter) { ?>
		<div class="share share-basic share-twitter">
			<a href="#" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=<?php echo rawurlencode($shareTitle) ?>
&amp;url=<?php echo $shareUrl ?>', '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<i class="fa fa-twitter"></i>
			</a>
		</div>
<?php } if ($options->theme->header->enableGooglePlus) { $gplusClass = count($socIconsEnabled) > 2 ? "share-advanced" : "share-basic" ?>
		<div<?php if ($_l->tmp = array_filter(array('share', 'share-gplus', $gplusClass))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
			<a href="#" onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo $shareUrl ?>', '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<i class="fa fa-google-plus"></i>
			</a>
		</div>
<?php } if (count($socIconsEnabled) > 2) { ?>
		<div class="share share-toggle" onclick="javascript: jQuery(this).parent().toggleClass('advanced-visible'); jQuery(this).find('i').toggleClass('fa-plus').toggleClass('fa-minus')"><i class="fa fa-plus"></i></div>
<?php } ?>
	</div>

	<script>
		jQuery(document).ready(function(){

			var toggleIcon = jQuery(".page-share .share-widgetarea");

			if(!isMobile()) {
				toggleIcon.mouseenter(function(){
					toggleIcon.addClass('hover');
				})
				.mouseleave(function(){
					toggleIcon.removeClass('hover');
				});
			} else {
				toggleIcon.click(function(){
					jQuery(this).toggleClass("hover");
				});
			}
		});
	</script>

</div>
<?php } 