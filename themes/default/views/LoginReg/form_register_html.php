<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_register_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2017 Whirl-i-Gig
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
		if(strlen($this->request->config->get('google_recaptcha_sitekey')) != 40 || strlen($this->request->config->get('google_recaptcha_secretkey')) != 40){
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
<?php
	if($co_security == 'captcha'){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {'sitekey': '<?php print $this->request->config->get('google_recaptcha_sitekey'); ?>'});
        	};
		</script>
<?php
	}
?>
	<form id="RegForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "register"); ?>" class="form-horizontal" role="form" method="POST">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
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
	    <div class="row"><div class="col-sm-4"><H1><?php print _t("Register"); ?></H1></div></div>
<?php
	}
	if($va_errors["register"]){
		print "<div class='alert alert-danger'>".$va_errors["register"]."</div>";
	}
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."' class='col-sm-4 control-label'>^LABEL</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
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
			<div class='form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>'>
				<label for='security' class='col-sm-4 control-label'><?php print _t("Security Question"); ?></label>
				<div class='col-sm-7'>
					<div class='col-sm-5'>
						<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
					</div>
					<div class='col-sm-5'>
						<input name="security" value="" id="security" type="text" class="form-control" />
					</div>
				</div><!-- end col-sm-7 -->
			</div><!-- end form-group -->
		
<?php
		}
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}
		print $t_user->htmlFormElement("password","<div class='form-group".(($va_errors["password"]) ? " has-error" : "")."'><label for='password' class='col-sm-4 control-label'>^LABEL</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		
?>
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2' class='col-sm-4 control-label'><?php print _t('Re-Type password'); ?></label>
			<div class="col-sm-7"><input type="password" name="password2" size="40" class="form-control"  autocomplete="off" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Register</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
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
	if($co_security == 'captcha'){
		print "<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>";
	}
?>
<?php
	}
?>
