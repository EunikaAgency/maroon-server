<?php //netteCache[01]000590a:2:{s:4:"time";s:21:"0.99071900 1646131445";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:102:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/post-content.php";i:2;i:1644560562;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/post-content.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'uama7bju7f')
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

<?php if (!$wp->isSingular) { ?>

<?php if ($wp->isSearch) { ?>

						<article <?php echo $post->htmlId ?> <?php echo $post->htmlClass('hentry') ?>>

<?php if ($post->isInAnyCategory) { ?>
					<div class="entry-data">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array() + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ?>

<?php if ($post->type == 'post') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ;} ?>
					</div>
<?php } ?>

				<header class="entry-header">

					<div class="entry-title">

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-date-format", ""), array('dateIcon' => $post->date('c'), 'dateLinks' => 'no', 'dateShort' => 'no') + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ?>

						<div class="entry-title-wrap">

							<h2><a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
"><?php echo $post->title ?></a></h2>

						</div><!-- /.entry-title-wrap -->
					</div><!-- /.entry-title -->
				</header><!-- /.entry-header -->

				<div class="entry-content loop">
					<?php echo $post->excerpt ?>

				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
" class="more"><?php echo $template->printf(__('%s Continue reading ...', 'wplatte'), '<span class="meta-nav">&rarr;</span>') ?></a>
				</footer><!-- /.entry-footer -->
			</article>

<?php } else { ?>

						<article <?php echo $post->htmlId ?> <?php echo $post->htmlClass ?>>
				<header class="entry-header <?php if (!$post->hasImage) { ?>nothumbnail<?php } ?>">

					<div class="entry-data">
<?php if ($post->isInAnyCategory) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array() + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ;} ?>

<?php if ($post->type == 'post') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ;} ?>

											</div>

					<div class="entry-thumbnail">


<?php if ($post->hasImage) { ?>
							<div class="entry-thumbnail-wrap entry-content">
							<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>" class="thumb-link">
								<span class="entry-thumbnail-icon">
									<img src="<?php echo aitResizeImage($post->imageUrl, array('width' => 1000, 'height' => 500, 'crop' => 1)) ?>
" alt="<?php echo NTemplateHelpers::escapeHtml($post->title, ENT_COMPAT) ?>" />
								</span>
							</a>
							</div>

<?php } ?>

<?php if ($post->isSticky and !$wp->isPaged and $wp->isHome) { ?>
							<div class="featured-post"><i class="fa fa-star"></i></div>
<?php } ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-date-format", ""), array('dateIcon' => $post->rawDate, 'dateLinks' => 'no', 'dateShort' => 'no') + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ?>

					</div>

					<div class="entry-title">
						<h2><a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
"><?php echo $post->title ?></a></h2>
					</div><!-- /.entry-title -->

				</header><!-- /.entry-header -->

				<div class="entry-content loop">
					<?php echo $post->excerpt ?>

				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
" class="more"><?php echo NTemplateHelpers::escapeHtml(__('Read more', 'wplatte'), ENT_NOQUOTES) ?></a>
										<!--	<span class="tags">
							<?php echo NTemplateHelpers::escapeHtmlComment(__('Tags: ', 'wplatte')) ?>
 <span class="tags-links"><?php echo $post->tagList ?></span>
						</span> -->
									</footer><!-- .entry-footer -->
			</article>
<?php } ?>

<?php } else { ?>

				<article <?php echo $post->htmlId ?> class="content-block">
			<div class="entry-content">
				<?php echo $post->content ?>

				<?php echo $post->linkPages ?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">
<?php if ($wp->isSingle and $post->author->bio and $post->author->isMulti) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/author-bio", ""), array() + get_defined_vars(), $_l->templates['uama7bju7f'])->render() ;} ?>
			</footer><!-- .entry-footer -->
		</article>

<?php } 