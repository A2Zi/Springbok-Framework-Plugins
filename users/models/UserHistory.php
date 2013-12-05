<?php
/** @TableAlias('uh') @TableName('user_history') */
class UserHistory extends SSqlModel{
	const CREATE=1, DELETE=2, UPDATE=3, CONNECT=5, LOST_PWD=6, CHANGE_PWD=7, VALID_USER=8, DISABLE_USER=9,
		CHANGE_EMAIL=10, VALID_CHANGE_EMAIL=11, CANCEL_CHANGE_EMAIL=12 ;
	public
		/** @Pk @AutoIncrement @SqlType('int(10) unsigned') @NotNull
		*/ $id,
		/** @SqlType('int(10) unsigned') @NotNull
		* @ForeignKey('User','id')
		*/ $user_id,
		/** @SqlType('tinyint(2) unsigned') @NotNull
		*/ $type,
		/** @SqlType('datetime') @NotNull
		*/ $created,
		/** @SqlType('int(10) unsigned') @Null @Default(NULL)
		*/ $rel_id;
	
	public static $belongsToType=array(
		'type'=>array(
			'dataName'=>'details',
			'types'=>array(
				05=>'UserConnection',
				06=>'UserHistoryPassword', 07=>'UserHistoryPassword',
				10=>'UserHistoryEmail', 11=>'UserHistoryEmail', 12=>'UserHistoryEmail',
			),
			'relations'=>array(
				'UserConnection'=>array(),
				'UserHistoryPassword'=>array(),
				'UserHistoryEmail'=>array()
			)
		)
	);
	
	
	public static function add($type,$relId=null,$userId=null){
		if($userId===null) $userId=CSecure::connected();
		$ph=new UserHistory;
		$ph->user_id=$userId;
		$ph->type=$type;
		if($relId !== null) $ph->rel_id=$relId;
		$ph->insert();
	}
	
	private static $_detailsOperation=array(self::CREATE=>'Création du compte',self::DELETE=>'Suppression du compte',self::UPDATE=>'Modification des informations',
		self::VALID_USER=>"Validation de l'utilisateur",self::DISABLE_USER=>"Désactivation de l'utilisateur",
		self::CONNECT=>'Connexion',self::LOST_PWD=>"Demande d'un nouveau mot de passe (perte)",self::CHANGE_PWD=>'Changement de mot de passe',
		self::CHANGE_EMAIL=>"Changement d'email",self::VALID_CHANGE_EMAIL=>"Validation du changement d'email",self::CANCEL_CHANGE_EMAIL=>"Annulation du changement d'email"
	);
	public function detailOperation(){
		return self::$_detailsOperation[$this->type];
	}
	
	public function details(){
		if(!isset($this->details)) return '';
		return ' : '.$this->details->details();
	}
}