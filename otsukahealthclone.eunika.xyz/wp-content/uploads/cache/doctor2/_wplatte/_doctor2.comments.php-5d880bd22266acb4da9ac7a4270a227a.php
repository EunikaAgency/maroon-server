<?php //netteCache[01]000579a:2:{s:4:"time";s:21:"0.94614700 1662606559";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:92:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/comments.php";i:2;i:1644561066;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/comments.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '9asdkc553u')
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
<div id="comments" class="comments-area">
<?php if ($post->hasComments) { ?>
	<h2 class="comments-title"><?php echo NTemplateHelpers::escapeHtml($template->printf(__('Comments (%s)', 'wplatte'), $post->commentsNumber), ENT_NOQUOTES) ?></h2>

	<ol class="commentlist">
<?php
				global $__wplattetemplate__;
				$__wplattetemplate__ = $template;
				if(!function_exists('__WpLatteListComments_9asdkc553u1662606559')):
					function __WpLatteListComments_9asdkc553u1662606559($__comment__, $args, $depth){
						global $__wplattetemplate__, $post;
						$template = $__wplattetemplate__; // bypassing $template object
						$GLOBALS['comment'] = $__comment__;
						$comment = WpLatte::createEntity('Comment', $__comment__, $post->post_author);
						$comment->loopData = array('args' => $args, 'depth' => $depth)	?>

<?php if (!$comment->isNormal) { ?>

		<li <?php echo $comment->htmlClass ?> <?php echo $comment->htmlId('li-') ?>>
			<?php ob_start() ?>(<?php echo NTemplateHelpers::escapeHtml(__('Edit', 'wplatte'), ENT_NOQUOTES) ?>
)<?php $editLinkLabel = ob_get_clean() ?>

			<p><?php echo NTemplateHelpers::escapeHtml(__('Pingback:', 'wplatte'), ENT_NOQUOTES) ?>
 <?php echo $comment->author->link ?> <span class="edit-link"><?php echo $comment->editLink($editLinkLabel) ?></span></p>

<?php } else { ?>

		<li <?php echo $comment->htmlClass ?> <?php echo $comment->htmlId('li-') ?>>
			<article <?php echo $comment->htmlId ?> class="comment-article">

				<header class="comment-meta">
					<div class="comment-author vcard">
						<?php echo $comment->author->avatar(50) ?>

						<cite class="fn"><?php echo $comment->author->link ?></cite>
					</div><!-- .comment-meta -->

					<a href="<?php echo NTemplateHelpers::escapeHtml($comment->url, ENT_COMPAT) ?>
"><time datetime="<?php echo NTemplateHelpers::escapeHtml($comment->time('c'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->printf(_x('%1$s at %2$s', '1: date, 2: time', 'wplatte'), $comment->date, $comment->time), ENT_NOQUOTES) ?></time></a>

					<div class="comment-tools">
						<?php ob_start() ?><span class="edit-link"><?php echo __('Edit', 'wplatte') ?>
</span><?php $editLinkLabel = ob_get_clean() ?>

	      				<?php echo $comment->editLink($editLinkLabel) ?>


						<?php ob_start() ?><span class="reply"><?php echo __('Reply <span>&darr;</span>', 'wplatte') ?>
</span><?php $replyLinkLabel = ob_get_clean() ?>

						<?php echo $comment->replyLink($replyLinkLabel) ?>

					</div>

				</header>

				<div class="entry-content comment-content">
<?php if (!$comment->isApproved) { ?>
						<p class="comment-awaiting-moderation"><?php echo NTemplateHelpers::escapeHtml(__('Your comment is awaiting moderation.', 'wplatte'), ENT_NOQUOTES) ?></p>
<?php } else { ?>
						<?php echo $comment->text ?>

<?php } ?>
				</div><!-- .comment-content -->

			</article><!-- #comment-## -->

<?php } ?>

			<?php 	} /* __WpLatteListComments_9asdkc553u1662606559 */
				endif;
				wp_list_comments(array('callback' => '__WpLatteListComments_9asdkc553u1662606559', 'style' => 'ol'))	?>
	</ol><!-- .commentlist -->


<?php if ($post->willCommentsPaginate) { ?>
	<nav class="navigation comment-navigation" role="navigation">
		<h1 class="assistive-text section-heading"><?php echo NTemplateHelpers::escapeHtml(__('Comment navigation', 'wplatte'), ENT_NOQUOTES) ?></h1>
		<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'wplatte')) ?></div>
		<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'wplatte')) ?></div>
	</nav>
<?php } ?>

<?php if ($post->hasCommentsClosed) { ?>
		<p class="nocomments"><?php echo NTemplateHelpers::escapeHtml(__('Comments are closed.', 'wplatte'), ENT_NOQUOTES) ?></p>
<?php } } ?>

<?php comment_form() ?>

</div><!-- #comments .comments-area -->
