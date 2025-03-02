<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2025 Whirl-i-Gig
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
$label_col = 2;
if($this->request->isAjax()){
	$label_col = 4;
?>
	<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
}
?>
		<H1><?= _t("Login"); ?></H1>
<?php
if($this->getVar("message")){
	print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
}
?>
	<form id="LoginForm" action="<?= caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form" method="POST">
		<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>
		<div class="form-group">
			<label for="username" class="col-sm-<?= $label_col; ?> control-label"><?= _t("Username"); ?></label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="username" name="username" autocomplete="off" />
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<div class="form-group">
			<label for="password" class="col-sm-<?= $label_col; ?> control-label"><?= _t("Password"); ?></label>
			<div class="col-sm-7" style="position: relative;">
				<input type="password" name="password" id="password" class="form-control form-control-lg">
				<div style="position:absolute; top: 6px; right: 24px;"><i id="showPassword" class="fas fa-eye text-info"></i></div>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<div class="form-group">
			<div class="col-sm-offset-<?= $label_col; ?> col-sm-7">
				<button type="submit" class="btn btn-default">login</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-<?= $label_col; ?> col-sm-7">
<?php
		if($this->request->isAjax()){
		
			if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) {
?>
			<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?= caNavUrl($this->request, '', 'LoginReg', 'registerForm', null); ?>');"><?= _t("Click here to register"); ?></a>
			<br/>
<?php
			}
?>
			<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?= caNavUrl($this->request, '', 'LoginReg', 'resetForm', null); ?>');"><?= _t("Forgot your password?"); ?></a>
<?php
		}else{
			if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) {
				print caNavLink($this->request, _t("Click here to register"), "", "", "LoginReg", "registerForm", array());
			}
			print "<br/>".caNavLink($this->request, _t("Forgot your password?"), "", "", "LoginReg", "resetForm", array());
		}
?>
			</div>
		</div><!-- end form-group -->
	</form>
<?php
	if($this->request->isAjax()){
?>
</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#LoginForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?= caNavUrl($this->request, '', 'LoginReg', 'login', null); ?>',
				jQuery('#LoginForm').serialize()
			);
			e.preventDefault();
			return false;
		});
		
        jQuery("#showPassword").click(function() {
       		jQuery(this).toggleClass("fas fa-eye fas fa-eye-slash");
         	var type = $(this).hasClass("fas fa-eye-slash") ? "text" : "password";
            jQuery("#password").attr("type", type);
        });
	});
</script>
<?php
}
