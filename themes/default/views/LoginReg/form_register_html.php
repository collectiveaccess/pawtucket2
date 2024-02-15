<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_register_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
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
	$show_group_code = $this->request->config->get('registration_show_group_code');
	$co_security = $this->request->config->get('registration_security');
	$co_security = $this->request->config->get('registration_security');
		if($co_security == 'captcha'){if((!defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") || !__CA_GOOGLE_RECAPTCHA_SECRET_KEY__) || (!defined("__CA_GOOGLE_RECAPTCHA_KEY__") || !__CA_GOOGLE_RECAPTCHA_KEY__)){
			//Then the captcha will not work and should not be implemenented. Alert the user in the console
			print "<script>console.log('reCaptcha disabled, please provide a valid site_key and secret_key to enable it.');</script>";
			$co_security = '';
		}
	}
?>

	<h1><?= _t("Register"); ?></h1>

	<form action="<?php print caNavUrl($this->request, "", "LoginReg", "register"); ?>" method="POST">
	<div class="bg-light px-4 pt-4 pb-2 mb-4">
			
		<div class="row my-2">
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			print "<div class='col-md-4 mb-4'>";
			print $t_user->htmlFormElement($vs_field,"<label for='".$vs_field."' class='form-label'>^LABEL</label>^ELEMENT\n", array("classname" => "form-control".(($va_errors[$vs_field]) ? " is-invalid" : "")));
			if($va_errors[$vs_field]){
				print "<div class='invalid-feedback'>".$va_errors[$vs_field]."</div>";
			}	
			print "</div>";
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				print "<div class='col-md-4 mb-4'>";
				print $va_profile_element["bs_formatted_element"];
				print "</div>";
			}
		}
		

		
		print "<div class='col-md-4 mb-4'>";
		print $t_user->htmlFormElement("password", "<label for='password' class='form-label'>^LABEL</label>^ELEMENT\n", array("classname" => "form-control".(($va_errors["password"]) ? " is-invalid" : "")));
		if($va_errors["password"]){
			print "<div class='invalid-feedback'>".$va_errors["password"]."</div>";
		}
		print "</div>";
?>
		<div class='col-md-4 mb-4'>
			<label for='password2' class='form-label'><?php print _t('Re-Type password'); ?></label>
			<input type="password" name="password2" id="password2" class="form-control<?php print (($va_errors["password"]) ? " is-invalid" : ""); ?>"  autocomplete="off" />
		</div>
<?php	
		if($show_group_code){
			print "<div class='col-md-4 mb-4'>";
			print "<label for='registrationGroupCode' class='form-label'>"._t("Group code (optional)")."</label>".caHTMLTextInput("group_code", ['class' => 'form-control'.(($va_errors["group_code"]) ? " is-invalid" : ""), 'id' => 'registrationGroupCode'], [])."\n";
			if($va_errors["group_code"]){
				print "<div class='invalid-feedback'>".$va_errors["group_code"]."</div>";
			}
			print "</div>";
		}
		if($co_security == "captcha"){
?>
			<script type="text/javascript">
				var gCaptchaRender = function(){
					grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
				};
			</script>
			<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
			<div class='col-md-4 mb-4'>
				<div id="regCaptcha"></div>
<?php
				if(($va_errors["recaptcha"])){
					print "<div class='invalid-feedback d-block'>".$va_errors["recaptcha"]."</div>";
				}
?>
        	</div>
<?php
		}
?>
		</div>
	</div>
		<div class="row mb-4">
			<div class="col-12 mb-4">
				<button type="submit" class="btn btn-primary"><?= _t("Register"); ?></button>
			</div>
			
			<input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
		</div>
		</form>

