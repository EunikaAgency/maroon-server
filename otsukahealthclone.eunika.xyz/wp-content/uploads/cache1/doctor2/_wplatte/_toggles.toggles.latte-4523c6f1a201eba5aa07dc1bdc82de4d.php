<?php //netteCache[01]000608a:2:{s:4:"time";s:21:"0.44679300 1644885214";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:120:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/toggles/toggles.latte";i:2;i:1644558948;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/toggles/toggles.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '1xdwbg0l3l')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($element->common('header'), $template->getParameters(), $_l->templates['1xdwbg0l3l'])->render() ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>
 type-<?php echo NTemplateHelpers::escapeHtml($el->option('type'), ENT_COMPAT) ?>">

<?php $query = WpLatteMacros::prepareCustomWpQuery(array('type' => 'toggle',
		'tax' => 'toggles',
		'cat' => $element->option('category'),
		'limit' => -1,
		'orderby' => $element->option('orderby'),
		'order' => $element->option('order'),)) ?>

<?php if ($query->havePosts) { if ($el->option('type') == 'accordion' || $el->option('type') == 'toggle') { foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
				<div class="toggle-header"><h3 class="toggle-title"><?php echo $item->title ?></h3></div>
  				<div class="toggle-content"><div class="toggle-container entry-content"><?php echo $item->content ?></div></div>
<?php endforeach; wp_reset_postdata(); } elseif ($el->option('type') == 'htabs') { ?>
						<select class="default-disabled responsive-tabs-select" style="display: none">
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
				<option value="#<?php echo $htmlId ?>-<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
"><?php echo $item->title ?></option>
<?php endforeach; wp_reset_postdata() ?>
			</select>
						<div class="tabs-wrapper">
				<div class="selected"></div>
				<ul><!--
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
					--><li><a href="#<?php echo $htmlId ?>-<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
"><?php echo $item->title ?></a></li><!--
<?php endforeach; wp_reset_postdata() ?>
				--></ul>
			</div>
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
			<div id="<?php echo $htmlId ?>-<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
" class="toggle-content entry-content"><?php echo $item->content ?></div>
<?php endforeach; wp_reset_postdata(); } else { ?>
						<select class="default-disabled responsive-tabs-select" style="display: none">
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
				<option value="#<?php echo $htmlId ?>-<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
"><?php echo $item->title ?></option>
<?php endforeach; wp_reset_postdata() ?>
			</select>
						<div class="tabs-wrapper">
				<div class="selected"></div>
				<ul>
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
					<li><a href="#<?php echo $htmlId ?>-<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
"><?php echo $item->title ?></a></li>
<?php endforeach; wp_reset_postdata() ?>
				</ul>
			</div>
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $item): ?>
			<div id="<?php echo $htmlId ?>-<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
" class="toggle-content entry-content"><?php echo $item->content ?></div>
<?php endforeach; wp_reset_postdata(); } } ?>
</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/toggles/javascript", ""), array() + get_defined_vars(), $_l->templates['1xdwbg0l3l'])->render() ;