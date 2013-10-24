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
			$mailer->AddAddress(Config::$contactFormDestEmail[Springbok::$scriptname]);
			$mailer->Subject='['.Config::$contactFormSiteName[Springbok::$scriptname].'] Contact de: '.$email;
			$mailer->Body='<p><b>Sujet : '.$subject.'</b></p><p>'.h($content).'</p>';
			$mailer->AddReplyTo($email);
			$mailer->Send();
			render();
		}else render('contact');
	}
}