<?php
Controller::$defaultLayout='admin/searchable';
/** @Check('ACSecureAdmin') @Acl('Searchable') */
class SearchableController extends Controller{
	/** */
	function index(){
		Searchable::Table()->paginate()->actionClick('view')->render('Searchable');
	}
	/** */
	function keywords(){
		SearchablesKeyword::Table()->noAutoRelations()->fields('id,_type,created,updated')
			->with('MainTerm','term,slug')
			->allowFilters()->paginate()->controller('searchableKeyword')->actionClick('view')
			->fields(array('id','term','slug','_type','created','updated'))
			->render('Keywords');
	}
	
	/** */
	function terms(){
		SearchablesTerm::Table()->noAutoRelations()->fields('id,term,slug,created,updated')
			->allowFilters()->paginate()->controller('searchableTerm')->actionClick('view')
			->fields(array('id','term','slug','created','updated'))
			->render('Terms');
	}
	
}