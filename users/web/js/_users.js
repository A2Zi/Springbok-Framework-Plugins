includeCore('ht5ifv');

window.users={
	loginRegister:function(){
		$('#formLogin,#formLostPassword,#formRegister')
			.ht5ifv({ events:{validate:'change.ht5ifv focus.ht5ifv',check:'change.ht5ifv'}, restrictions:this.ht5ifvRestrictions() });
		$('#formLostPassword').ajaxForm(function(data){
			if(data!=='0'){
				var divLostPassword=$('#divLostPassword').html('');
				$('<div class="message success" style="display:none;opacity:0"/>').html('<b>Mot de passe envoyé !</b><br/>Vérifiez vos emails, puis connectez vous dans le formulaire ci-dessus.').appendTo(divLostPassword).animate({opacity:1,height:'show'},'fast');
			}else $('<div class="message error bold" style="display:none;opacity:0"/>').text('Impossible de renvoyer de mot de passe à cette adresse.').prependTo($('#formLostPassword'))
						.animate({opacity:1,height:'show'},'fast').delay(4500).animate({opacity:0,height:'hide'},800);
		});
	},
	ht5ifvRestrictions:function(){
		var registerDivHelp={Pseudo:{20:'Le pseudo est vide.',21:'Le pseudo est déjà utilisé.',22:'Le pseudo n\'est pas conforme.'},
			Email:{20:'L\'adresse est vide.',21:'Cette adresse email est déjà utilisée par un compte.',22:'Le nom de domaine n\'est pas valide.'}},
			registerDivInvalidChecks={},registerPreviousValidity={},registerCachedValidity={},registerDivPseudoInvalid=false,pseudoPreviousValidity=true;
		return {
			'data-ajaxcheck':function($node,$ignoreEmpty){
				var val=$node.val(),checkName=$node.data('ajaxcheck').sbUcFirst(),img,valid,errorCode,exception=$node.data('checkexception');
				if(val===''){
					if(registerDivInvalidChecks[checkName]){
						registerDivInvalidChecks[checkName].remove(); delete registerDivInvalidChecks[checkName];
						registerPreviousValidity[checkName]=false;
					}
					return false;
				}
				if(exception && val===exception) return true;
				
				$node.after(img=$('<img src="'+imgUrl+'ajax-roller.gif" style="position:absolute;right:2px;top:2px"/>'));
				if(registerCachedValidity[checkName] && registerCachedValidity[checkName][val]!==undefined) errorCode=registerCachedValidity[checkName][val];
				else{
					registerCachedValidity[checkName]||(registerCachedValidity[checkName]={});
					registerCachedValidity[checkName][val]=errorCode=S.syncGet(basedir+'users/check'+checkName,{val:val});
				}
				valid=errorCode==='1';
				img.remove();
				if(valid){
					if(registerDivInvalidChecks[checkName]){
						registerDivInvalidChecks[checkName].animate({opacity:0,height:'hide'},'slow',function(){
							if(registerDivInvalidChecks[checkName]){
								registerDivInvalidChecks[checkName].remove(); delete registerDivInvalidChecks[checkName];
								registerPreviousValidity[checkName]=false;
							}
						});
					}
				}else{
					if(!registerPreviousValidity[checkName]){
						registerPreviousValidity[checkName]=true;
						$node.after(registerDivInvalidChecks[checkName]=$('<div class="message error bold" style="display:none;opacity:0"/>').text(registerDivHelp[checkName][errorCode]))
						registerDivInvalidChecks[checkName].animate({opacity:1,height:'show'},'fast');
					}
				}
				return valid;
			}
		};
	}
};