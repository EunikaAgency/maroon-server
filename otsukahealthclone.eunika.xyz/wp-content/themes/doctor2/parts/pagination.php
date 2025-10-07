{* ********************************************************* *}
{* COMMON DATA                                               *}
{* ********************************************************* *}

	{capture $navPrevText}{!_x '%s Previous', 'previous' |printf: '<span class="meta-nav">&larr;</span>'}{/capture}
	{capture $navNextText}{!_x 'Next %s', 'next' |printf: '<span class="meta-nav">&rarr;</span>'}{/capture}

	{if !isset($location)} {var $location = ''} {/if}
	{if !isset($arrow)} {var $arrow = ''} {/if}

	{var $arrowLeft = ''}
	{var $arrowRight = ''}

{* ********************************************************* *}
{* for ATTACHMENT				                             *}
{* ********************************************************* *}
{if $wp->isAttachment}
	{var $arrowLeft = 'yes'}
	{var $arrowRight = 'yes'}
	{capture $navPrevLink}<span class="nav-previous">{prevImageLink false, $navPrevText}</span>{/capture}
	{capture $navNextLink}<span class="nav-next">{nextImageLink false, $navNextText}</span>{/capture}
{* ********************************************************* *}
{* for POST DETAIL, IMAGE DETAIL and PORTFOLIO DETAIL 		 *}
{* ********************************************************* *}
{elseif $wp->isSingle}
	{if $wp->hasPreviousPost or $wp->hasNextPost}
		{if $wp->hasPreviousPost}
			{var $arrowLeft = 'yes'}
			{capture $navPrevLink}<span class="nav-previous">{prevPostLink $navPrevText}</span>{/capture}
		{/if}
		{if $wp->hasNextPost}
			{var $arrowRight = 'yes'}
			{capture $navNextLink}<span class="nav-next">{nextPostLink $navNextText}</span>{/capture}
		{/if}
	{/if}
{* ********************************************************* *}
{* for OTHER										 		 *}
{* ********************************************************* *}
{else}
	{if $wp->willPaginate}
		{var $arrowLeft = 'yes'}
		{var $prevLink = get_previous_posts_link($navPrevText) ? get_previous_posts_link($navPrevText) : '<a href="#">'.$navPrevText.'</a>'}
		{*{capture $navPrevLink}<span class="nav-previous{if !$wp->hasPreviousPosts} disabled{/if}">{prevPostsLink $navPrevText}</span>{/capture}*}
		{capture $navPrevLink}<span class="nav-previous{if !$wp->hasPreviousPosts} disabled{/if}">{!$prevLink}</span>{/capture}

		{var $arrowRight = 'yes'}
		{var $nextLink = get_next_posts_link($navNextText) ? get_next_posts_link($navNextText) : '<a href="#">'.$navNextText.'</a>'}
		{*{capture $navNextLink}<span class="nav-next{if !$wp->hasNextPosts} disabled{/if}">{nextPostsLink $navNextText}</span>{/capture}*}
		{capture $navNextLink}<span class="nav-next{if !$wp->hasNextPosts} disabled{/if}">{!$nextLink}</span>{/capture}
	{/if}
{/if}

{* ********************* *}
{* RESULTS               *}
{* ********************* *}
{if $arrow != ''}
	{if $arrow == 'left'}
		{if $arrowLeft == 'yes'}{!$navPrevLink}{/if}
	{else}
		{if $arrowRight == 'yes'}{!$navNextLink}{/if}
	{/if}
{else}
	{if $wp->hasPreviousPosts or $wp->hasNextPosts}
		<nav class="nav-single {$location}" role="navigation">
		{if $arrowLeft == 'yes'}{!$navPrevLink}{/if}
		{if $wp->willPaginate}{if !$wp->isSingular}{pagination}{/if}{/if}
		{if $arrowRight == 'yes'}{!$navNextLink}{/if}
		</nav>
	{/if}
{/if}
