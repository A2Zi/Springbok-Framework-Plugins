<?php
Controller::$defaultLayout='admin/cms';
/** @Check('ACSecureAdmin') @Acl('Posts') */
class PostHistoriesController extends Controller{
	/** @Ajax @ValidParams @Required('id') */
	function view(int $id){
		set('history',PostHistory::QAll()->fields('id,created')->byPost_id($id)->orderByCreated()->paginate()->execute());
		render();
	}
	
	/** @ValidParams @Required('id') */
	function history(int $id){
		$history=PostHistory::QOne()->byId($id);
		notFoundIfFalse($history);
		mset($history);
		render();
	}
	
	/** @Ajax @ValidParams @Required('id') */
	function restore(int $id){
		$history=PostHistory::QOne()->byId($id);
		notFoundIfFalse($history);
		$history->restore();
		Post::onModified($history->post_id);
		redirect('/posts/edit/'.$history->post_id);
	}
}