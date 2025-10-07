<?php //netteCache[01]000581a:2:{s:4:"time";s:21:"0.87783400 1662606559";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:94:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/attachment.php";i:2;i:1644561066;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/attachment.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '1fpuow98n7')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb3994d4ef0b_content')) { function _lb3994d4ef0b_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;foreach($iterator = new WpLatteLoopIterator() as $post): $mime = explode('/', $post->attachment->mimeType) ?>

		<div class="detail-half-content detail-attachment-content">
				<div class="detail-thumbnail">
<?php if ($post->attachment->isImage) { ?>
						<a href="<?php echo NTemplateHelpers::escapeHtml($post->attachment->url, ENT_COMPAT) ?>
"><?php echo $post->attachment->image(array(960, 960)) ?></a>
<?php } elseif ($post->attachment->isVideo) { ?>
												<?php echo wp_video_shortcode(array('src' => $post->attachment->url)) ?>

<?php } elseif ($post->attachment->isAudio) { ?>
												<?php echo wp_audio_shortcode(array('src' => $post->attachment->url)) ?>

<?php } else { ?>
						OTHER
						<a href="<?php echo NTemplateHelpers::escapeHtml($post->attachment->url, ENT_COMPAT) ?>
"><span class="attachment-icon attachment-icon-<?php echo $mime[1] ?>"></span></a>
<?php } ?>
				</div>
				<div class="detail-description">
					<!--<div class="detail-text entry-content">
<?php if ($post->hasContent) { ?>
							<?php echo $post->content ?>

<?php } else { ?>
							<?php echo $post->excerpt ?>

<?php } ?>
					</div>-->
					<div class="detail-info">
<?php if ($post->hasContent) { ?>
						<p>
							<span class="info-title">Description:</span>
							<span class="info-value"><?php echo $template->striptags($post->content) ?></span>
						</p>
<?php } if ($post->attachment->isImage or $post->attachment->isVideo) { ?>
						<p>
							<span class="info-title">Dimensions:</span>
							<span class="info-value"><?php echo NTemplateHelpers::escapeHtml($post->attachment->width, ENT_NOQUOTES) ?>
 x <?php echo NTemplateHelpers::escapeHtml($post->attachment->height, ENT_NOQUOTES) ?></span>
						</p>
<?php } ?>
						<p>
							<span class="info-title">File Type:</span>
							<span class="info-value"><?php echo $mime[1] ?></span>
						</p>
						<p>
							<span class="info-title">File Size:</span>
							<span class="info-value"><?php echo NTemplateHelpers::escapeHtml(size_format(filesize(get_attached_file($post->attachment->id))), ENT_NOQUOTES) ?></span>
						</p>

					</div>
				</div>
			<?php echo $post->linkPages ?>

		</div><!-- .detail-content -->

		<footer class="entry-footer">
<?php if ($wp->isSingle and $post->author->bio and $post->author->isMulti) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/author-bio", ""), array() + get_defined_vars(), $_l->templates['1fpuow98n7'])->render() ;} ?>
		</footer><!-- .entry-footer -->

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('location' => 'nav-below') + get_defined_vars(), $_l->templates['1fpuow98n7'])->render() ?>

<?php endforeach; 
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof NPresenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>

<?php if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 