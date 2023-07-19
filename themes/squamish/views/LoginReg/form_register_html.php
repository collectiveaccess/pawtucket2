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
	if($this->request->isAjax()){
?>
<div id="caFormOverlay">
<?php
	}
?>
<script type="text/javascript">
	// initialize CA Utils
	caUI.initUtils();
</script>
	<form id="RegForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "register"); ?>" class="form-horizontal" role="form" method="POST">
	    <input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
	if($this->request->isAjax()){
?>
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
				<H1><?php print _t("Register"); ?></H1>
			</div>
		</div>
<?php
	}else{
?>
	    <div class="row"><div class="col-md-12 col-lg-10 col-lg-offset-1"><H1><?php print _t("Register"); ?></H1></div></div>
<?php
	}
?>
		<div class="row"><div class="col-md-12 col-lg-10 col-lg-offset-1">
<?php
	if($va_errors["register"]){
		print "<div class='alert alert-danger'>".$va_errors["register"]."</div>";
	}
		print "<div class='form-group'>";
		foreach(array("fname", "lname", "email") as $vs_field){
			print "<div class='col-sm-4'>";
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."''>^LABEL</label>^ELEMENT</div></div>\n", array("classname" => "form-control"));
		}
		print "</div>";
?>
		<div class='form-group'>
			<div class='col-sm-4'>
<?php
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}
		print $t_user->htmlFormElement("password", "<label for='password' class='control-label'>^LABEL</label>^ELEMENT\n", array("classname" => "form-control"));
?>
			</div>
			<div class='col-sm-4'>
				<label for='password2' class='control-label'><?php print _t('Re-Type password'); ?></label>
				<input type="password" name="password2" id="password2" size="40" class="form-control"  autocomplete="off" />
		
			</div>
			<div class="col-sm-4 <?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
<?php
		if($co_security == 'captcha'){
?>
			<script type="text/javascript">
				var gCaptchaRender = function(){
					grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
				};
			</script>
			<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
			<div class='form-group<?php print (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
        		<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
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
				
				<label for='security' class='control-label'><?php print _t("Security Question"); ?></label>
				<div class='form-group'><div class="col-sm-3"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </div><div class="col-sm-9"><input name="security" value="" id="security" type="text" class="form-control" /></div></div>

<?php
		}
?>

			</div>
		</div>
<?php		
		$va_profile_settings = $this->getVar("profile_settings");
?>
		<div class="row bgLightGray">
			<div class="col-sm-12">
				<H2>Squamish Nation Members and Staff</H2>
				<p class="formTextLarge">{{{register_member_staff_instructions}}}</p>
				
				<div class="form-group">
					<div class="col-sm-6 <?php print (($va_errors["user_profile_band_number"]) ? " has-error" : ""); ?>">
						<b>Squamish Nation Members</b>
						<p>{{{register_member_instructions}}}</p>
<?php

						if($va_errors["user_profile_band_number"]){
							print "<div class='alert alert-danger'>".$va_errors["user_profile_band_number"]."</div>";
						}
?>
						<label for="member_code" class="control-label">Squamish Nation Member Registration Code</label>
						<input type="text" name="member_code" maxlength="70" class="form-control" value="<?php print html_entity_decode(strip_tags($this->request->getParameter("member_code", pString))); ?>">
						
						<label for="pref_user_profile_band_number" class="control-label"><?php print $va_profile_settings["user_profile_band_number"]["label"]; ?></label>
						<input type="text" name="pref_user_profile_band_number" maxlength="70" class="form-control" value="<?php print html_entity_decode(strip_tags($this->request->getParameter("pref_user_profile_band_number", pString))); ?>">
					</div><!-- end col-sm-6 -->
					<div class="col-sm-6 <?php print (($va_errors["user_profile_staff_jde_number"]) ? " has-error" : ""); ?>">
						<b>Squamish Nation Staff</b>
						<p>{{{register_staff_instructions}}}</p>
<?php
						if($va_errors["user_profile_staff_jde_number"]){
							print "<div class='alert alert-danger'>".$va_errors["user_profile_staff_jde_number"]."</div>";
						}
?>
						<label for="staff_code" class="control-label">Squamish Nation Staff Registration Code</label>
						<input type="text" name="staff_code" maxlength="70" class="form-control" value="<?php print html_entity_decode(strip_tags($this->request->getParameter("staff_code", pString))); ?>">
						
						<label for="pref_user_profile_staff_jde_number" class="control-label"><?php print $va_profile_settings["user_profile_staff_jde_number"]["label"]; ?></label>
						<input type="text" name="pref_user_profile_staff_jde_number" maxlength="70" class="form-control" value="<?php print html_entity_decode(strip_tags($this->request->getParameter("pref_user_profile_staff_jde_number", pString))); ?>">
					</div><!-- end col-sm-6 -->
				</div>
			</div>
		</div>
			<div class="form-group">
				<div class="col-sm-12 text-center">
					<br/><button type="submit" class="btn btn-default"><?php print _t('Register'); ?></button>
				</div><!-- end col-sm-7 -->
			</div><!-- end form-group -->
			<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">

		</div></div>
	</form>
<?php
	if($this->request->isAjax()){
?>
</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#RegForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'register', null); ?>',
				jQuery('#RegForm').serializeObject()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>