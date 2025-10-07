<?php //netteCache[01]000588a:2:{s:4:"time";s:21:"0.99840300 1644645984";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:100:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/page-title.php";i:2;i:1644561067;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/page-title.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '47p0fdylvp')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$customBg = $el->option('customBg') ?>

	<?php ob_start() ?><span class="edit-link"><?php echo __('Edit', 'wplatte') ?></span><?php $editLinkLabel = ob_get_clean() ?>


<?php $titleClass = '' ;$titleName = '' ;$editButton = '' ;$titleImage = '' ;$dateIcon = '' ;$dateLinks = '' ;$dateShort = '' ;$dateInterval = '' ;$titleAuthor = '' ;$titleCategory = '' ;$titleComments = '' ;$titleSubDesc = '' ;$titleDesc = $el->option('description') ;$showPager = '' ?>


<?php if ($wp->is404 or $wp->isSearch or $wp->isWoocommerce()) { ?>

	 <?php if ($wp->is404) { ?>				<?php $titleClass = "simple-title" ?> <?php } ?>

	 <?php if ($wp->isSearch) { ?>			<?php $titleClass = "simple-title" ?> <?php } ?>

	 <?php if ($wp->isWoocommerce()) { ?>	<?php $titleClass = "simple-title" ?> <?php } ?>


	 <?php if ($wp->is404) { ?>				<?php ob_start() ;echo NTemplateHelpers::escapeHtml(__("This is somewhat embarrassing, isn't it?", 'wplatte'), ENT_NOQUOTES) ;$titleName = ob_get_clean() ?>
			<?php } ?>

	 <?php if ($wp->isSearch) { ob_start() ?>
															<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($wp->searchQuery, ENT_NOQUOTES) ?>
</span><?php $searchTitle = ob_get_clean() ?>

															<?php echo $template->printf(__('Search Results for: %s', 'wplatte'), $searchTitle) ?>

														<?php $titleName = ob_get_clean() ?>																				<?php } ?>

	 <?php if ($wp->isWoocommerce()) { ?>	<?php ob_start() ;woocommerce_page_title() ;$titleName = ob_get_clean() ?>
								<?php } ?>


<?php } elseif ($wp->isPage or $wp->isSingular('post') or $wp->isSingular('portfolio-item') or $wp->isSingular('event') or $wp->isSingular('job-offer') or $wp->isAttachment) { foreach($iterator = new WpLatteLoopIterator() as $post): ?>

	 <?php if ($wp->isPage) { ?> 					<?php $titleClass = "standard-title" ?> 				<?php } ?>

	 <?php if ($wp->isSingular('post')) { ?> 			<?php $titleClass = "post-title" ?>
 					<?php } ?>

	 <?php if ($wp->isSingular('portfolio-item')) { ?> <?php $titleClass = "post-title portfolio-title" ?>
 	<?php } ?>

	 <?php if ($wp->isSingular('event')) { ?> 			<?php $titleClass = "post-title event-title" ?>
 		<?php } ?>

	 <?php if ($wp->isSingular('job-offer')) { ?> 		<?php $titleClass = "post-title job-offer-title" ?>
	<?php } ?>

	 <?php if ($wp->isAttachment) { ?>				<?php $titleClass = "post-title attach-title" ?>
		<?php } ?>


	 <?php if ($wp->isSingular('event')) { $meta = $post->meta('event-data') ?>
						   <?php } elseif ($wp->isSingular('job-offer')) { ?>	<?php $meta = $post->meta('offer-data') ?>

<?php } ?>

<?php $titleName = $post->title ;$titleImage = $post->imageUrl ?>
						   <?php if ($wp->isAttachment or $wp->isSingular('portfolio-item') or $wp->isSingular('job-offer')) { ?>
 <?php $titleImage = '' ?> <?php } ?>

	 <?php ob_start() ;echo $post->editLink($editLinkLabel) ;$editButton = ob_get_clean() ?>


	 <?php if ($wp->isSingular('post')) { ?> 			<?php $dateIcon = $post->rawDate ?>
  		<?php $dateLinks = 'yes' ?>	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isSingular('portfolio-item')) { ?> <?php $dateIcon = $post->rawDate ?>
 		<?php $dateLinks = 'no' ?> 	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isSingular('event')) { ?> 			<?php $dateIcon = $meta->dateFrom ?>
 		<?php $dateLinks = 'no' ?> 	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isSingular('job-offer')) { ?> 		<?php $dateIcon = $meta->validFrom ?>
		<?php $dateLinks = 'no' ?> 	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isAttachment) { ?> 				<?php $dateIcon = $post->rawDate ?>  		<?php $dateLinks = 'no' ?>
		<?php $dateShort = 'no' ?> <?php } ?>


	 <?php if ($wp->isSingular('event')) { ?>			<?php ob_start() ;echo NTemplateHelpers::escapeHtml(__('Duration:', 'wplatte'), ENT_NOQUOTES) ;$intLabel = ob_get_clean() ?>

<?php $intFrom = $meta->dateFrom ;$intTo = $meta->dateTo ?>
																<?php if ($intTo) { $dateInterval = 'yes' ;} ?>

<?php } ?>
	 <?php if ($wp->isSingular('job-offer')) { ?>		<?php ob_start() ;echo NTemplateHelpers::escapeHtml(__('Validity:', 'wplatte'), ENT_NOQUOTES) ;$intLabel = ob_get_clean() ?>

<?php $intFrom = $meta->validFrom ;$intTo = $meta->validTo ;$dateInterval = 'yes' ;} ?>

	 <?php if ($wp->isSingular('post')) { ?> 			<?php $titleAuthor = 'yes' ?> <?php } ?>

	 <?php if ($wp->isAttachment) { ?> 				<?php $titleAuthor = 'yes' ?> <?php } ?>


	 <?php if ($post->categoryList) { ?>				<?php $titleCategory = 'yes' ?> <?php } ?>

	 <?php if ($wp->isSingular('post')) { ?>			<?php $titleComments = 'yes' ?> <?php } ?>


	 <?php if ($wp->isSingular('post')) { ?> 			<?php $showPager = 'yes' ?> <?php } ?>

<?php endforeach ?>

<?php } elseif ($wp->isBlog and $blog) { ?>

<?php $titleClass = "blog-title" ;$titleName = $blog->title ;$titleImage = $blog->imageUrl ?>
	 <?php ob_start() ;echo $blog->editLink($editLinkLabel) ;$editButton = ob_get_clean() ?>


<?php } elseif ($wp->isCategory or $wp->isArchive or $wp->isTag or $wp->isAuthor or $wp->isTax('portfolios')) { ?>

<?php $titleClass = "archive-title" ?>

	 <?php if ($wp->isCategory) { ob_start() ?>
																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($category->title, ENT_NOQUOTES) ?>
</span><?php $categoryTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Category Archives: %s', 'wplatte'), $categoryTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isTag) { ?>					<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($tag->title, ENT_NOQUOTES) ?>
</span><?php $tagTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Tag Archives: %s', 'wplatte'), $tagTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isPostTypeArchive) { ?>		<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->title, ENT_NOQUOTES) ?>
</span><?php $archiveTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Archives: %s', 'wplatte'), $archiveTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isTax) { ?>					<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($taxonomyTerm->title, ENT_NOQUOTES) ?>
</span><?php $taxonomyTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Category Archives: %s', 'wplatte'), $taxonomyTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isAuthor) { ?>				<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($author, ENT_NOQUOTES) ?>
</span><?php $authorTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('All posts by %s', 'wplatte'), $authorTitle) ?>

<?php $titleName = ob_get_clean() ;} elseif ($wp->isArchive) { ?>
								<?php if ($archive->isDay) { ob_start() ?>
																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->dateI18n('F j, Y'), ENT_NOQUOTES) ?>
</span><?php $dayTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Daily Archives: %s', 'wplatte'), $dayTitle) ?>

<?php $titleName = ob_get_clean() ?>
								<?php } elseif ($archive->isMonth) { ?>		<?php ob_start() ?>

																	<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('F Y', 'monthly archives date format', 'wplatte'), ENT_NOQUOTES) ;$monthFormat = ob_get_clean() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->dateI18n($monthFormat), ENT_NOQUOTES) ?>
</span><?php $monthTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Monthly Archives: %s', 'wplatte'), $monthTitle) ?>

<?php $titleName = ob_get_clean() ?>
								<?php } elseif ($archive->isYear) { ?>		<?php ob_start() ?>

																	<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('Y',  'yearly archives date format', 'wplatte'), ENT_NOQUOTES) ;$yearFormat = ob_get_clean() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->dateI18n($yearFormat), ENT_NOQUOTES) ?>
</span><?php $yearTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Yearly Archives: %s', 'wplatte'), $yearTitle) ?>

<?php $titleName = ob_get_clean() ?>
								<?php } else { ?>							<?php ob_start() ;echo __('Archives:', 'wplatte') ;$titleName = ob_get_clean() ?>

<?php } } ?>

	 <?php if ($wp->isCategory) { ?>					<?php $titleSubDesc = $category->description ?>
 	<?php } ?>

	 <?php if ($wp->isTag) { ?>						<?php $titleSubDesc = $tag->description ?> 		<?php } ?>


<?php } ?>


<div style="display: none;">
<?php echo NTemplateHelpers::escapeHtml($titleClass, ENT_NOQUOTES) ?>

<?php echo $titleName ?>

<?php echo $editButton ?>

<?php echo NTemplateHelpers::escapeHtml($titleImage, ENT_NOQUOTES) ?>

<?php echo NTemplateHelpers::escapeHtml($dateIcon, ENT_NOQUOTES) ?>

<?php echo NTemplateHelpers::escapeHtml($dateLinks, ENT_NOQUOTES) ?>

<?php echo NTemplateHelpers::escapeHtml($dateShort, ENT_NOQUOTES) ?>


<?php if ($dateInterval == 'yes') { echo NTemplateHelpers::escapeHtml($intLabel, ENT_NOQUOTES) ?>
 <?php echo NTemplateHelpers::escapeHtml($template->dateI18n($intFrom), ENT_NOQUOTES) ?>
 - <?php echo NTemplateHelpers::escapeHtml($template->dateI18n($intTo), ENT_NOQUOTES) ;} ?>

<?php if ($titleAuthor == 'yes') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ;} ?>

<?php if ($titleCategory == 'yes') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array() + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ;} ?>

<?php if ($titleComments == 'yes') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/comments-link", ""), array() + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ;} ?>

<?php echo $titleSubDesc ?>

<?php echo $titleDesc ?>

</div>


<div class="page-title"<?php if ($titleImage) { ?> style="background-image: url('<?php echo aitResizeImage($titleImage, array('width' => 1000, 'height' => 500, 'crop' => 1)) ?>
')"<?php } ?>>
	<div class="grid-main">

		<header class="entry-header<?php if ($titleImage or $customBg['image'] != "") { ?>
 has-image<?php } ?>">

			<div class="entry-title <?php echo NTemplateHelpers::escapeHtml($titleClass, ENT_COMPAT) ?>">

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-date-format", ""), array('dateIcon' => $dateIcon, 'dateLinks' => $dateLinks, 'dateShort' => $dateShort) + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ?>

				<div class="entry-title-wrap">

					<h1><?php echo $titleName ?></h1>

<?php if ($dateInterval == 'yes' or $titleCategory == 'yes' or $titleComments == 'yes' or $titleSubDesc) { ?>
						<div class="entry-data">

<?php if ($dateInterval == 'yes') { ?>
								<div class="date-interval">
									<span class="date-interval-title"><strong><?php echo NTemplateHelpers::escapeHtml($intLabel, ENT_NOQUOTES) ?></strong></span>
									<time class="event-from" datetime="<?php echo NTemplateHelpers::escapeHtml($template->date($intFrom, c), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($intFrom), ENT_NOQUOTES) ?></time>
									<span class="date-sep">-</span>
									<time class="event-to" datetime="<?php echo NTemplateHelpers::escapeHtml($template->date($intTo, c), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($intTo), ENT_NOQUOTES) ?></time>
								</div>
<?php } ?>

							<?php if ($titleCategory == 'yes') { ?>	<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array() + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ?>
	<?php } ?>

																	<?php if ($titleSubDesc) { ?>				<?php echo $titleSubDesc ?>						<?php } ?>

						</div>
<?php } ?>

					<!--
						<div class="entry-meta">
							<?php echo $editButton ?>

						</div>-->
									</div>
			</div>

			<!--
				<div class="entry-thumbnail">
					<div class="entry-thumbnail-wrap">
						<a href="<?php echo NTemplateHelpers::escapeHtmlComment($titleImage) ?>" class="thumb-link">
							<span class="entry-thumbnail-icon">
								<img src="<?php echo aitResizeImage($titleImage, array('width' => 1000, 'height' => 500, 'crop' => 1)) ?>
" alt="<?php echo NTemplateHelpers::escapeHtmlComment($titleName) ?>">
							</span>
						</a>
					</div>
				</div>-->
<?php if ($titleDesc) { ?>
				<div class="page-description"><?php echo $titleDesc ?></div>
<?php } ?>

<?php if ($wp->isSingular('post') and $post->excerpt) { ?>
				<div class="page-description"><?php echo $post->excerpt ?></div>
<?php } ?>

<?php if ($titleAuthor == 'yes') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ;} ?>

<?php if ($showPager) { ?>
			<nav class="nav-single" role="navigation">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('arrow' => 'left') + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ;NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('arrow' => 'right') + get_defined_vars(), $_l->templates['47p0fdylvp'])->render() ?>
			</nav>
<?php } ?>

		</header><!-- /.entry-header -->

<?php if ($titleImage) { ?>
			<a href="<?php echo NTemplateHelpers::escapeHtml($titleImage, ENT_COMPAT) ?>" class="thumb-link"><i class="fa fa-search"></i></a>
<?php } ?>

	</div>
</div>