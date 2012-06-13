<?php
class VPostsLatest extends SViewCachedElement{
	/* DEV */ public function exists(){ return false; } /* /DEV */
	public static function path(){return DATA.'elementsCache/posts/latest-list';}
	public static function vars(){
		return array(
			'posts'=>Post::QAll()->byStatus(Post::PUBLISHED)
				->fields('id,title,slug,excerpt,created,published,updated')
				->orderByCreated()
				/*->with('PostsAuthor','name,url')*/
				->limit(4)
				->execute()
		);
	}
}
