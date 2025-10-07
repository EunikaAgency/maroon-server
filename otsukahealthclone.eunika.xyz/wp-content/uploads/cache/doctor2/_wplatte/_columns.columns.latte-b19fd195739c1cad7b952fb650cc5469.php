<?php //netteCache[01]000597a:2:{s:4:"time";s:21:"0.99572100 1752479105";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:109:"/var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/columns/columns.latte";i:2;i:1752474530;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/columns/columns.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'wtw3032lcz')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($element->common('header'), $template->getParameters(), $_l->templates['wtw3032lcz'])->render() ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="column-grid <?php echo NTemplateHelpers::escapeHtml($element->gridCssClass, ENT_COMPAT) ?>">
<?php global $post ;$iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($element->columnsCssClasses) as $i => $class) { ?>
		<div<?php if ($_l->tmp = array_filter(array('column', $class, $element->isNarrowColumn($class) ? 'column-narrow':null, $iterator->first ? 'column-first':null, $iterator->last ? 'column-last':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>

<?php $iterations = 0; foreach ($element->getElementsOfColumn($i) as $columnElement) { if ($columnElement->id == 'comments'  && !comments_open($post->ID) && get_comments_number($post->ID) == 0) { ?>

					<!-- COMMENTS DISABLED -->

<?php } else { if ($columnElement->display and $columnElement->sortable) { ?>					<section id="<?php echo NTemplateHelpers::escapeHtml($columnElement->htmlId, ENT_COMPAT) ?>
-main" class="<?php echo NTemplateHelpers::escapeHtml($columnElement->htmlClasses, ENT_COMPAT) ?>">

						<div class="elm-wrapper <?php echo NTemplateHelpers::escapeHtml($columnElement->htmlClass, ENT_COMPAT) ?>-wrapper">

<?php if($columnElement->getId() === 'columns' or $columnElement->isEnabled()){
				NCoreMacros::includeTemplate($columnElement->getTemplate(), array('el' => $columnElement, 'element' => $columnElement, 'htmlId' => $columnElement->getHtmlId(), 'htmlClass' => $columnElement->getHtmlClass()) + $template->getParameters(), $_l->templates['wtw3032lcz'])->render();
			}else{
				echo AitWpLatteMacros::elementPlaceholder($columnElement);
			} ?>

						</div><!-- .elm-wrapper -->

					</section>
<?php } } $iterations++; } ?>

		</div>

<?php $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>

</div>
