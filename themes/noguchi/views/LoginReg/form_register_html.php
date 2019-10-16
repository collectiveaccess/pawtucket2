<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_register_html.php
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	$co_security = $this->request->config->get('registration_security');
?>
<main class="ca archive">

	<section>
		<div class="wrap">
            <div class="wrap-text-large">
				<div class="block-quarter">
					<H3 class="subheadline-bold text-align-center"><?php print _t("Request Login"); ?></H3>

	<form id="RegForm" action="<?php print caNavUrl("", "LoginReg", "register"); ?>" class="form-horizontal" role="form" method="POST">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>

<?php
	if($va_errors["register"]){
		print "<div class='alert alert-danger'>".$va_errors["register"]."</div>";
	}
		foreach(array("fname", "lname", "email") as $vs_field){
			print "<div class='block-half'>";
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<label for='".$vs_field."' class='eyebrow'>^LABEL</label><br/>^ELEMENT\n");
			print "</div>";
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				print "<div class='block-half'>";
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				print "<label for='".$vs_field."' class='eyebrow'>".$va_profile_element["label"]."</label><br/>";
				print $va_profile_element["element"];
				print "</div>";
			}
		}
		print "<div class='block-half'>";
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}
		print $t_user->htmlFormElement("password", "<label for='password' class='eyebrow'>^LABEL</label><br/>^ELEMENT\n", array("classname" => "form-control"));
		print "</div>";
?>
		<div class='block-half'>
			<label for='password2' class='eyebrow'><?php print _t('Re-Type password'); ?></label><br/>
			<input type="password" name="password2" size="40" class="form-control"  autocomplete="off" />
		</div>
<?php
		if(($co_security == 'captcha') && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
			<script type="text/javascript">
				var gCaptchaRender = function(){
					grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
				};
			</script>
			<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>

			<div class='block-half'>
<?php
			if($va_errors["recaptcha"]){
				print "<div class='alert alert-danger'>".$va_errors["recaptcha"]."</div>";
			}	
?>
				<div id="regCaptcha"></div>
        	</div>
<?php		
		}
?>		
		<div class='block-half text-align-center'>
			<button type="submit" class="button"><?php print _t('Send'); ?></button>
		</div>
	</form>
				
				
				
				</div>
			</div>
		</div>
	</section>
</main>