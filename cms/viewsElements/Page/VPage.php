<?php
class VPage extends SViewCachedElement{
	protected static $views=array('view','metas');
	
	/*#if DEV*/ public function exists(){ return false; } /*#/if*/
	
	public static function path($id){return array('pages',$id);}
	
	public static function vars($id){
		$page=Page::QOne()->where(array('id'=>$id))->mustFetch();
		$page->content=UHtml::transformInternalLinks($page->content,Config::$internalLinks,'index',false);
		
		return array('page'=>$page);
	}
	public function metas(){
		return json_decode($this->_store->read('metas'),true);
	}
}