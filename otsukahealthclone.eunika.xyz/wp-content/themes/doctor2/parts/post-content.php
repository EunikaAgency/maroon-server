
	{if !$wp->isSingular}

		{if $wp->isSearch}

			{*** SEARCH RESULTS ONLY ***}

			<article {!$post->htmlId} {!$post->htmlClass('hentry')}>

				{if $post->isInAnyCategory}
					<div class="entry-data">
						{includePart parts/entry-categories}

						{if $post->type == post}
							{includePart parts/entry-author}
						{/if}
					</div>
				{/if}

				<header class="entry-header">

					<div class="entry-title">

						{includePart parts/entry-date-format, dateIcon => $post->date('c'), dateLinks => 'no', dateShort => 'no'}

						<div class="entry-title-wrap">

							<h2><a href="{$post->permalink}">{!$post->title}</a></h2>

						</div><!-- /.entry-title-wrap -->
					</div><!-- /.entry-title -->
				</header><!-- /.entry-header -->

				<div class="entry-content loop">
					{!$post->excerpt}
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<a href="{$post->permalink}" class="more">{!__ '%s Continue reading ...'|printf: '<span class="meta-nav">&rarr;</span>'}</a>
				</footer><!-- /.entry-footer -->
			</article>

		{else}

			{*** STANDARD LOOP ***}

			<article {!$post->htmlId} {!$post->htmlClass}>
				<header class="entry-header {if !$post->hasImage}nothumbnail{/if}">

					<div class="entry-data">
						{if $post->isInAnyCategory}
							{includePart parts/entry-categories}
						{/if}

						{if $post->type == post}
							{includePart parts/entry-author}
						{/if}

						{* includePart parts/comments-link *}
					</div>

					<div class="entry-thumbnail">


						{if $post->hasImage}
							<div class="entry-thumbnail-wrap entry-content">
							<a href="{$post->permalink}" class="thumb-link">
								<span class="entry-thumbnail-icon">
									<img src="{imageUrl $post->imageUrl, width => 1000, height => 500, crop => 1}" alt="{$post->title}">
								</span>
							</a>
							</div>

						{/if}

						{if $post->isSticky and !$wp->isPaged and $wp->isHome}
							<div class="featured-post"><i class="fa fa-star"></i></div>
						{/if}

						{includePart parts/entry-date-format, dateIcon => $post->rawDate, dateLinks => 'no', dateShort => 'no'}

					</div>

					<div class="entry-title">
						<h2><a href="{$post->permalink}">{!$post->title}</a></h2>
					</div><!-- /.entry-title -->

				</header><!-- /.entry-header -->

				<div class="entry-content loop">
					{!$post->excerpt}
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<a href="{$post->permalink}" class="more">{__ 'Read more'}</a>
					{* if $post->tagList *}
					<!--	<span class="tags">
							{__ 'Tags: '} <span class="tags-links">{!$post->tagList}</span>
						</span> -->
					{* /if *}
				</footer><!-- .entry-footer -->
			</article>
		{/if}

	{else}

		{*** POST DETAIL ***}

		<article {!$post->htmlId} class="content-block">
			<div class="entry-content">
				{!$post->content}
				{!$post->linkPages}
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				{if $wp->isSingle and $post->author->bio and $post->author->isMulti}
					{includePart parts/author-bio}
				{/if}
			</footer><!-- .entry-footer -->
		</article>

	{/if}
