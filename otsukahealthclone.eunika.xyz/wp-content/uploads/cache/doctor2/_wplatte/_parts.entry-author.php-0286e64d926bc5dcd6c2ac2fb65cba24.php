<?php //netteCache[01]000590a:2:{s:4:"time";s:21:"0.98140200 1646131445";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:102:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/entry-author.php";i:2;i:1644561066;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/parts/entry-author.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '2gq4tmw635')
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
<span class="author vcard">

<?php ob_start() ?>
		<span class="auth-links">
			<a class="url fn n" href="<?php echo NTemplateHelpers::escapeHtml($post->author->postsUrl, ENT_COMPAT) ?>
" title="<?php echo NTemplateHelpers::escapeHtml($template->printf(__('View all posts by %s', 'wplatte'), $post->author), ENT_COMPAT) ?>
" rel="author"><?php echo NTemplateHelpers::escapeHtml($post->author, ENT_NOQUOTES) ?></a>
		</span>
<?php $authorlink = ob_get_clean() ?>
	<?php echo $template->printf(__('Posted by %s', 'wplatte'), $authorlink) ?>


</span>