{=$pagination=HPagination::simple($posts)}

<ul class="nobullets cMt10">
{f $posts->getResults() as $post}
	<?php $postLink=$post->link() ?>
	<li itemscope itemtype="http://schema.org/Article" class="block1 clearfix">
		{if!null $post->image->image_id}
			<?php $url=STATIC_URL.'/files/library/'.$post->image->image_id; ?>
			{link '<img class="floatL mr10" itemprop="image" content="'.$url.'.jpg" width="75" height="75" src="'.$url.'-medium.jpg" />',$postLink,array('escape'=>false)}
		{/if}
		<h3 class="noclear" itemprop="name">{link $post->name,$postLink,array('itemprop'=>'url')}</h3>
		<? VPost::create($post->id)->render('excerpt') ?>
		<div class="alignRight">{link _t('plugin.blog.readMore'),$postLink}</div>
		<div>{if!e $post->tags}{t 'plugin.blog.Tags:'} <? implode(', ',array_map(function(&$tag){return HHtml::link($tag->name,$tag->link());},$post->tags)) ?><br />{/if}
		{link _t('plugin.blog.permalink'),$postLink}/*#if blog_comments_enabled*/{if $post->isCommentsAllowed()} | {if $post->comments===0}{t 'plugin.blog.NoComments'}
			{else}<? HHtml::link(_t_p('Comments',$post->comments),$post->link+array('#'=>'comments')) ?> ({$post->comments}){/if}{/if}/*#/if*/
		 | <span itemprop="dateCreated" content="{$post->created}"></span>
			{t 'plugin.blog.PublishedOn'} <span itemprop="datePublished" content="{=$post->published}"><? HTime::simple($post->published) ?></span>
			{if!null $post->updated}, {t 'plugin.blog.updatedOn'} <span itemprop="dateModified" content="{=$post->updated}"><? HTime::simple($post->updated) ?></span>{/if}
		</div>
	</li>
{/f}
</ul>

{=$pagination}
