<?php
class SiteController extends AController{
	/** */
	static function contact(){
		render();
	}
	
	
	/** @NotEmtpy('name','email','subject','content','captcha')
	* email > @Email */
	static function contact_submit($name,$email,$subject,$content,$captcha){
		if(!CValidation::hasErrors() && CCaptcha::check()){
			$mailer=CMail::get();
			$mailer->AddAddress(isset(Config::$contactFormDestEmail[Springbok::$scriptname])?Config::$contactFormDestEmail[Springbok::$scriptname]:Config::$adminEmail);
			$mailer->Subject='['.isset(Config::$contactFormSiteName[Springbok::$scriptname])?Config::$contactFormSiteName[Springbok::$scriptname]:Config::$projectName.'] Contact de: '.$email;
			$mailer->Body='<p><b>Sujet : '.$subject.'</b></p><p>'.h($content).'</p>';
			$mailer->AddReplyTo($email);
			$mailer->Send();
			render();
		}else render('contact');
	}
}