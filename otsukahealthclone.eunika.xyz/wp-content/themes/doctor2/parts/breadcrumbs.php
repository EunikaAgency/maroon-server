{if $options->layout->general->showBreadcrumbs}
<div class="breadcrumb">
	<div class="grid-main">
		{breadcrumbs $options->theme->breadcrumbs}
		<div class="search">
		{searchForm}
		</div>	
	</div>
</div>
{/if}