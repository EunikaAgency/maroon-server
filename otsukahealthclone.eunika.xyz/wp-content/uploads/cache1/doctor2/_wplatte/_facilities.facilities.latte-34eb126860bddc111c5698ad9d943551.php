<?php //netteCache[01]000614a:2:{s:4:"time";s:21:"0.39273700 1644572349";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:126:"/home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/facilities/facilities.latte";i:2;i:1644560682;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /home/585141.cloudwaysapps.com/mefvckxeyh/public_html/wp-content/themes/doctor2/ait-theme/elements/facilities/facilities.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'dtkm6knpuj')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($el->common('header'), $template->getParameters(), $_l->templates['dtkm6knpuj'])->render() ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>">

<?php $items = array() ?>

<?php if (is_array($el->option('category'))) { $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($el->option('category')) as $cat) { $query = WpLatteMacros::prepareCustomWpQuery(array('type' => 'facility', 'tax' => 'facilities', 'cat' => intval($cat), 'limit' => -1, 'orderby' => $el->option('orderby'), 'order' => $el->option('order'))); if ($query->havePosts) { foreach ($iterator = new WpLatteLoopIterator($query) as $item): array_push($items, $item) ;endforeach; wp_reset_postdata(); } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ;} else { $query = WpLatteMacros::prepareCustomWpQuery(array('type' => 'facility', 'tax' => 'facilities', 'cat' => $el->option('category'), 'limit' => -1, 'orderby' => $el->option('orderby'), 'order' => $el->option('order'))); if ($query->havePosts) { foreach ($iterator = new WpLatteLoopIterator($query) as $item): array_push($items, $item) ;endforeach; wp_reset_postdata(); } } ?>

<?php if (count($items) != 0) { $numOfColumns    = $el->option->itemColumns ;$displayDesc     = $el->option->displayDesc ?>

		<div<?php if ($_l->tmp = array_filter(array('facilities-container', "column-{$numOfColumns}",))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($items) as $item) { $meta = $item->meta("facility-data") ;$hasImage = $meta->icon != '' ? true : false ?>

			<div<?php if ($_l->tmp = array_filter(array('item', "item{$iterator->counter}", $iterator->isFirst($numOfColumns) ? 'item-first':null, $iterator->isLast($numOfColumns) ? 'item-last':null, $hasImage ? 'image-present':null, $displayDesc ? 'desc-on' : 'desc-off'))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
				<div class="item-thumbnail">
					<div class="item-icon" style="<?php if ($el->isColor($meta->iconColor)) { ?>
background-color: <?php echo $meta->iconColor ?>; border-color: <?php echo $meta->iconColor ?>
;<?php } ?>"><img src="<?php echo NTemplateHelpers::escapeHtml($meta->icon, ENT_COMPAT) ?>" alt="icon" /></div>
				</div>
				<?php if ($meta->link != "") { ?><a href="<?php echo NTemplateHelpers::escapeHtml($meta->link, ENT_COMPAT) ?>
"><?php } ?>

					<div class="item-data">
						<h4 class="item-title"><?php echo $item->title ?></h4>
<?php if ($displayDesc) { ?>
						<div class="item-desc"><p><?php echo $meta->description ?></p></div>
<?php } ?>
					</div>
				<?php if ($meta->link != "") { ?></a><?php } ?>

			</div>
<?php $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
		</div>

<?php } else { ?>
		<div class="facilities-container">
			<div class="alert alert-info">
				<?php echo NTemplateHelpers::escapeHtml(_x('Facilities', 'name of element', 'wplatte'), ENT_NOQUOTES) ?>
&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo NTemplateHelpers::escapeHtml(__('Info: There are no items created, add some please.', 'wplatte'), ENT_NOQUOTES) ?>

			</div>
		</div>
<?php } ?>

</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/facilities/javascript", ""), array() + get_defined_vars(), $_l->templates['dtkm6knpuj'])->render() ;