<?php //netteCache[01]000588a:2:{s:4:"time";s:21:"0.98757500 1646131445";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:100:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/pagination.php";i:2;i:1644561067;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/pagination.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '4uwf403baf')
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
	<?php ob_start() ;echo $template->printf(_x('%s Previous', 'previous', 'wplatte'), '<span class="meta-nav">&larr;</span>') ;$navPrevText = ob_get_clean() ?>

	<?php ob_start() ;echo $template->printf(_x('Next %s', 'next', 'wplatte'), '<span class="meta-nav">&rarr;</span>') ;$navNextText = ob_get_clean() ?>


	<?php if (!isset($location)) { ?> <?php $location = '' ?> <?php } ?>

	<?php if (!isset($arrow)) { ?> <?php $arrow = '' ?> <?php } ?>


<?php $arrowLeft = '' ;$arrowRight = '' ?>

<?php if ($wp->isAttachment) { $arrowLeft = 'yes' ;$arrowRight = 'yes' ?>
	<?php ob_start() ?><span class="nav-previous"><?php previous_image_link(false, $navPrevText) ?>
</span><?php $navPrevLink = ob_get_clean() ?>

	<?php ob_start() ?><span class="nav-next"><?php next_image_link(false, $navNextText) ?>
</span><?php $navNextLink = ob_get_clean() ?>

<?php } elseif ($wp->isSingle) { if ($wp->hasPreviousPost or $wp->hasNextPost) { if ($wp->hasPreviousPost) { $arrowLeft = 'yes' ?>
			<?php ob_start() ?><span class="nav-previous"><?php previous_post_link("%link", $navPrevText) ?>
</span><?php $navPrevLink = ob_get_clean() ?>

<?php } if ($wp->hasNextPost) { $arrowRight = 'yes' ?>
			<?php ob_start() ?><span class="nav-next"><?php next_post_link("%link", $navNextText) ?>
</span><?php $navNextLink = ob_get_clean() ?>

<?php } } } else { if ($wp->willPaginate) { $arrowLeft = 'yes' ;$prevLink = get_previous_posts_link($navPrevText) ? get_previous_posts_link($navPrevText) : '<a href="#">'.$navPrevText.'</a>' ?>
				<?php ob_start() ?><span class="nav-previous<?php if (!$wp->hasPreviousPosts) { ?>
 disabled<?php } ?>"><?php echo $prevLink ?></span><?php $navPrevLink = ob_get_clean() ?>


<?php $arrowRight = 'yes' ;$nextLink = get_next_posts_link($navNextText) ? get_next_posts_link($navNextText) : '<a href="#">'.$navNextText.'</a>' ?>
				<?php ob_start() ?><span class="nav-next<?php if (!$wp->hasNextPosts) { ?> disabled<?php } ?>
"><?php echo $nextLink ?></span><?php $navNextLink = ob_get_clean() ?>

<?php } } ?>

<?php if ($arrow != '') { if ($arrow == 'left') { ?>
		<?php if ($arrowLeft == 'yes') { echo $navPrevLink ;} ?>

<?php } else { ?>
		<?php if ($arrowRight == 'yes') { echo $navNextLink ;} ?>

<?php } } else { if ($wp->hasPreviousPosts or $wp->hasNextPosts) { ?>
		<nav class="nav-single <?php echo NTemplateHelpers::escapeHtml($location, ENT_COMPAT) ?>" role="navigation">
		<?php if ($arrowLeft == 'yes') { echo $navPrevLink ;} ?>

		<?php if ($wp->willPaginate) { if (!$wp->isSingular) { echo WpLatteMacros::pagination(array()); } } ?>

		<?php if ($arrowRight == 'yes') { echo $navNextLink ;} ?>

		</nav>
<?php } } 