{var $type = isset($elements->unsortable["page-title"]->option->type) ? $elements->unsortable["page-title"]->option->type : 'standard'}

{var $shareUrl 				= ""}
{var $shareTitle 			= ""}
{var $shareImage 			= ""}
{var $shareDescription		= ""}

{if $wp->isPage or $wp->isSingular(post) or $wp->isSingular(portfolio-item) or $wp->isSingular(event) or $wp->isSingular(job-offer) or $wp->isSingular(doc) or $wp->isSingular(theme)}
	{loop as $post}
		{var $shareUrl 			= $post->permalink}
		{var $shareTitle 		= $post->title}
		{var $shareImage 		= isset($post->ID) ? wp_get_attachment_url(get_post_thumbnail_id($post->ID)) : wp_get_attachment_url(get_post_thumbnail_id($post->id))}
		{var $shareDescription	= substr(strip_tags($post->excerpt), 0, 100)}

		{if $type == 'theme' && $wp->isPage}
			{customQuery as $query, id => $elements->unsortable["page-title"]->option->theme, type => 'theme'}
			{if $query->havePosts}
				{customLoop from $query as $item}
					{var $shareTitle 		= $item->meta('theme')->subtitle}
					{var $shareDescription 	= strip_tags($item->content)}
					{var $shareImage 		= $item->imageUrl}
				{/customLoop}
			{/if}
		{/if}

	{/loop}
{else}
	{var $qobj = get_queried_object()}
	{if $qobj and isset($qobj->ID)}
		{var $shareUrl 				= get_permalink($qobj->ID)}
		{var $shareTitle 			= get_the_title($qobj->ID)}
		{var $shareDescription		= ''}
	{/if}
{/if}

{* OVERRIDE BY SEO ELEMENT *}
	{var $SEOOptions = $elements->unsortable["seo"]->option}

	{if isset($SEOOptions->title) && $SEOOptions->title != ""}
		{var $shareTitle = $SEOOptions->title}
	{/if}
	{if isset($SEOOptions->description) && $SEOOptions->description != ""}
		{var $shareDescription 	= substr($SEOOptions->description, 0, 80)}
	{/if}
{* OVERRIDE BY SEO ELEMENT *}

{* PREPARE FOR SHARE
{var $strFind = array("&")}
{var $strReplace = array("and")}
{var $shareTitle = urlencode(str_replace($strFind, $strReplace, $shareTitle))}
PREPARE FOR SHARE *}

{if $showShare == "enabled" and $shareUrl and $shareTitle}

{var $socIconsEnabled = array()}
{if $options->theme->header->enableFacebook}
	{? array_push($socIconsEnabled, 'facebook') }
{/if}
{if $options->theme->header->enableTwitter}
	{? array_push($socIconsEnabled, 'twitter') }
{/if}
{if $options->theme->header->enableGooglePlus}
	{? array_push($socIconsEnabled, 'google') }
{/if}

<div class="page-share">
	<div class="content">
		{if $wp->isWidgetAreaActive($options->theme->header->headerWidgetArea->sidebar)}
		<div class="share share-widgetarea">
			<div class="icon-content">
				<i class="fa fa-lightbulb-o"></i>
			</div>
			<div class="area-content">
				{widgetArea $options->theme->header->headerWidgetArea->sidebar}
			</div>
		</div>
		{/if}
		
		{if count($socIconsEnabled) > 0}
		<div class="share share-title">
			<span class="title-content">{__ 'Share'}</span>
		</div>
		{/if}

		{if $options->theme->header->enableFacebook}
		<div class="share share-basic share-facebook">
			<a href="#" onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u={!$shareUrl}', '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<i class="fa fa-facebook"></i>
			</a>
		</div>
		{/if}
		{if $options->theme->header->enableTwitter}
		<div class="share share-basic share-twitter">
			<a href="#" onclick="javascript:window.open('https://twitter.com/intent/tweet?text={!rawurlencode($shareTitle)}&amp;url={!$shareUrl}', '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<i class="fa fa-twitter"></i>
			</a>
		</div>
		{/if}
		{* Every next icon needs to have class share-advanced *}
		{if $options->theme->header->enableGooglePlus}
		{var $gplusClass = count($socIconsEnabled) > 2 ? "share-advanced" : "share-basic"}
		<div n:class="share, share-gplus, $gplusClass">
			<a href="#" onclick="javascript:window.open('https://plus.google.com/share?url={!$shareUrl}', '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<i class="fa fa-google-plus"></i>
			</a>
		</div>
		{/if}
		{* Every next icon needs to have class share-advanced *}

		{if count($socIconsEnabled) > 2}
		<div class="share share-toggle" onclick="javascript: jQuery(this).parent().toggleClass('advanced-visible'); jQuery(this).find('i').toggleClass('fa-plus').toggleClass('fa-minus')"><i class="fa fa-plus"></i></div>
		{/if}
	</div>

	<script>
		jQuery(document).ready(function(){

			var toggleIcon = jQuery(".page-share .share-widgetarea");

			if(!isMobile()) {
				toggleIcon.mouseenter(function(){
					toggleIcon.addClass('hover');
				})
				.mouseleave(function(){
					toggleIcon.removeClass('hover');
				});
			} else {
				toggleIcon.click(function(){
					jQuery(this).toggleClass("hover");
				});
			}
		});
	</script>

</div>
{/if}
