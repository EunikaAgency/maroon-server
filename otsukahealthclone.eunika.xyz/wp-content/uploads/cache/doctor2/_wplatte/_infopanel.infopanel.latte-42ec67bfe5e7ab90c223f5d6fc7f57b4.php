<?php //netteCache[01]000601a:2:{s:4:"time";s:21:"0.64689900 1752475520";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:113:"/var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/infopanel/infopanel.latte";i:2;i:1752474530;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.2";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"2.0.4";}}}?><?php

// source file: /var/www/html/otsukahealthclone.eunika.xyz/wp-content/themes/doctor2/ait-theme/elements/infopanel/infopanel.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '35vdb8fs08')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($el->common('header'), $template->getParameters(), $_l->templates['35vdb8fs08'])->render() ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>">

<?php $query = WpLatteMacros::prepareCustomWpQuery(array('type' => 'infopanel', 'tax' => 'infopanels', 'cat' => $el->option('category'), 'limit' => -1, 'orderby' => 'menu_order', 'order' => 'ASC')) ?>

<?php if ($query->havePosts) { ?>
		<div class="data-container">
			<div class="content">
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $panel): $meta = $panel->meta('infopanel-data') ?>

				<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-panel-<?php echo NTemplateHelpers::escapeHtml($panel->id, ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('panel-container', $iterator->isFirst() ? 'panel-active':null, $panel->hasImage ? 'image-present':null, $panel->content ? 'content-present':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php if ($panel->hasImage) { ?>
					<div class="thumbnail-container" style="background-image: url('<?php echo aitResizeImage($panel->imageUrl, array('width' => 480, 'height' => 810, 'crop' => 1, 'crop_from_position' => 'center,center')) ?>')">
						<!-- <img src="<?php echo aitResizeImage($panel->imageUrl, array('width' => 480, 'height' => 810, 'crop' => 1, 'crop_from_position' => 'center,center')) ?>
" alt="<?php echo $panel->title ?>"> -->
					</div>
<?php } ?>
					<div class="content-container entry-content">
						<?php echo $panel->content ?>

					</div>
<?php if (($meta->title) || ($meta->description) || ( is_array($meta->data) && count($meta->data) > 0 )) { ?>
						<div class="options-container">
							<h3 class="options-title"><?php echo NTemplateHelpers::escapeHtml($meta->title, ENT_NOQUOTES) ?></h3>

<?php if (is_array($meta->data) && count($meta->data) > 0) { ?>
								<div class="data-container">
<?php $iterations = 0; foreach ($meta->data as $data) { ?>
									<span class="data-row">
										<span class="data-name"><?php echo NTemplateHelpers::escapeHtml($data['name'], ENT_NOQUOTES) ?></span>
										<span class="data-value"><?php echo NTemplateHelpers::escapeHtml($data['value'], ENT_NOQUOTES) ?></span>
									</span>
<?php $iterations++; } ?>
								</div>
<?php } ?>

							<span class="options-description"><?php echo NTemplateHelpers::escapeHtml($meta->description, ENT_NOQUOTES) ?></span>
						</div>
<?php } ?>
				</div>
<?php endforeach; wp_reset_postdata() ?>

				<div class="tabs-container">
					<div class="content">
						<ul><!--
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $panel): ?>
							--><li data-order="<?php echo NTemplateHelpers::escapeHtml($iterator->getCounter(), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array($iterator->isFirst() ? 'active':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>
><a href="#" data-panel="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>
-panel-<?php echo NTemplateHelpers::escapeHtml($panel->id, ENT_COMPAT) ?>"><?php echo $panel->title ?></a></li><!--
<?php endforeach; wp_reset_postdata() ?>
						--></ul>
					</div>
				</div>

			</div>
		</div>

<?php } else { ?>

		<div class="alert alert-info">
			<?php echo NTemplateHelpers::escapeHtml(_x('Infopanel', 'name of element', 'wplatte'), ENT_NOQUOTES) ?>
&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo NTemplateHelpers::escapeHtml(__('Info: There are no panels created, add some please.', 'wplatte'), ENT_NOQUOTES) ?>

		</div>

<?php } ?>
</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/infopanel/javascript", ""), array() + get_defined_vars(), $_l->templates['35vdb8fs08'])->render() ;