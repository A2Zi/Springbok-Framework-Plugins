<li>
	<?php $postLink=$post->link() ?>
	<article itemscope itemtype="http://schema.org/Article" class="clearfix">
		{if!null $post->image->image_id}
			<?php $url=STATIC_URL.'/files/library/'.$post->image->image_id; ?>
			{link '<img class="floatL mr10" itemprop="image" content="'.$url.'.jpg" width="75" height="75" src="'.$url.'-medium.jpg" />',$postLink,array('escape'=>false,'entry'=>'index','fullUrl'=>false)}
		{/if}
		<h3 class="noclear" itemprop="name">{link $post->name,$postLink,array('itemprop'=>'url','entry'=>'index','fullUrl'=>false)}</h3>
		<span itemprop="dateCreated" content="{$post->created}"></span>
		<span itemprop="datePublished" content="{$post->published}"></span>
		{if!null $post->updated}<span itemprop="dateModified" content="{$post->updated}"></span>{/if}
		{if isset($post->excerpt)}{=$post->excerpt}{else}<? VPost::create($post->id)->render('excerpt') ?>{/if}
	</article>
</li>