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
	$co_security = $this->request->config->get('registration_security');
	if($co_security == 'captcha'){
		if((!defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") || !__CA_GOOGLE_RECAPTCHA_SECRET_KEY__) || (!defined("__CA_GOOGLE_RECAPTCHA_KEY__") || !__CA_GOOGLE_RECAPTCHA_KEY__)){
			//Then the captcha will not work and should not be implemenented. Alert the user in the console
			print "<script>console.log('reCaptcha disabled, please provide a valid site_key and secret_key to enable it.');</script>";
			$co_security = 'equation_sum';
		}
	}
?>
<script type="text/javascript">
	// initialize CA Utils
	caUI.initUtils();
</script>

<div class="row mt-5 mb-5">
	<div class="col-sm-12 offset-md-3 col-md-6 offset-lg-4 col-lg-4">
		<H1><?php print _t("Register"); ?></H1>
		<form id="RegForm" action="<?php print caNavUrl("", "LoginReg", "register"); ?>" class="form-horizontal" role="form" method="POST">
	    <input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken(); ?>"/>
<?php
		if($va_errors["register"]){
			print "<div class='alert alert-danger'>".$va_errors["register"]."</div>";
		}
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."'>^LABEL</label>^ELEMENT</div><!-- end form-group -->\n", array("classname" => "form-control"));
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				
				print "<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'>"; 
				print $va_profile_element["bs_formatted_element"];
				print "</div><!-- end form-group -->";
			}
		}
		if($co_security == 'captcha'){
?>
			<script type="text/javascript">
				var gCaptchaRender = function(){
					grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
				};
			</script>
			<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
			<div class='form-group<?php print (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
        		<div id="regCaptcha"></div>
        	</div>
<?php		
		} else {
			if($va_errors["security"]){
				print "<div class='alert alert-danger'>".$va_errors["security"]."</div>";
			}
			$vn_num1 = rand(1,10);
			$vn_num2 = rand(1,10);
			$vn_sum = $vn_num1 + $vn_num2;
?>
			<div class='form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>'>
				<label for='security'><?php print _t("Security Question"); ?></label>
				<div class="row">
					<div class='col-sm-3'>
						<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
					</div>
					<div class='col-sm-5'>
						<input name="security" value="" id="security" type="text" class="form-control" />
					</div>
				</div><!-- end row -->
			</div><!-- end form-group -->
<?php
		}
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}
		print $t_user->htmlFormElement("password", "<div class='form-group".(($va_errors["password"]) ? " has-error" : "")."'><label for='password'>^LABEL</label>^ELEMENT</div><!-- end form-group -->\n", array("classname" => "form-control"));
?>
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2' class='control-label'><?php print _t('Re-Type password'); ?></label>
			<input type="password" name="password2" id="password2" size="40" class="form-control"  autocomplete="off" />
		</div><!-- end form-group -->
		
<?php	
		if($va_errors["group_code"]){
			print "<div class='alert alert-danger'>".$va_errors["group_code"]."</div>";
		}
		print "<div class='form-group".(($va_errors["group_code"]) ? " has-error" : "")."'><label for='registrationGroupCode'>"._t("Group code (optional)")."</label>".caHTMLTextInput("group_code", ['class' => 'form-control', 'id' => 'registrationGroupCode'], [])."</div>\n";
?>
			<div class="form-group">
				<button type="submit" class="btn btn-primary"><?php print _t('Register'); ?></button>
			</div><!-- end form-group -->
			<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		</form>
	</div>
</div>