<?php
Controller::$defaultLayout='admin/searchable';
/** @Check('ACSecureAdmin') @Acl('Searchable') */
class SearchableTermAbbrController extends Controller{
	/** @ValidParams('/searchable') @Id @NotEmpty('term') */
	static function autocomplete(int $id,$term){
		$termsAbbrId=SearchablesTermAbbreviation::QValues()->field('abbr_id')->byTerm_id($id)->fetch();
		$where=array('term LIKE'=>$term.'%','stt.type'=>SearchablesTypedTerm::ABBREVIATION);
		if(!empty($termsAbbrId)) $where['id NOTIN']=$termsAbbrId;
		self::renderJSON(json_encode(
			SearchablesTerm::QRows()->withForce('Types')
				->setFields(array('id','(term)'=>'name'))->where($where)->limit(14)
				->fetch()
		));
	}
	
	/** @ValidParams('/searchable') @Id('abbrId','termId') */
	static function add(int $abbrId,int $termId){
		SearchablesTypedTerm::addIgnore($abbrId,SearchablesTypedTerm::ABBREVIATION);
		if(SearchablesTermAbbreviation::create($termId,$abbrId))
			renderText('1');
	}
	/** @ValidParams('/searchable') @Id('abbrId','termId') */
	static function del(int $abbrId,int $termId){
		if(SearchablesTermAbbreviation::QDeleteOne()->where(array('term_id'=>$termId,'abbr_id'=>$abbrId))->execute())
			renderText('1');
	}
	/** @ValidParams('/searchable') @Id('termId') @NotEmpty('val') */
	static function create(int $termId,$val){
		$abbrId=SearchablesTerm::createOrGet($val,SearchablesTypedTerm::ABBREVIATION);
		if(SearchablesTermAbbreviation::create($termId,$abbrId))
			renderText('1');
	}
}