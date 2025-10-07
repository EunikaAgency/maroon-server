{if $options->theme->social->enableSocialIcons}
<div class="social-icons">
	<ul><!--
		{foreach $options->theme->social->socIcons as $icon}
			--><li class="{if $icon->iconFont}iconFont{else}iconImg{/if}">
				<a href="{$icon->url}" {if $options->theme->social->socIconsNewWindow}target="_blank"{/if}>
					{if $icon->iconFont}
						<i class="fa {$icon->iconFont}"></i>
					{else}
						{if $icon->icon}<img src="{$icon->icon}" class="s-icon s-icon-light" alt="icon">{/if}
					{/if}
					<span class="s-title">{$icon->title}</span>
				</a>
			</li><!--
		{/foreach}
	--></ul>
</div>
{/if}
