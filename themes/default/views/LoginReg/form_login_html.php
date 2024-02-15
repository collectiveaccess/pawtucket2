<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
?> 
			<H1><?php print _t("Login"); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
		<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" method="POST">
			<input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
	<div class="row">
		<div class="col-md-12 col-lg-6">			
			<div class="bg-light px-4 pt-4 pb-2 mb-4">
				<div class="row">
					<div class="col mb-4">
						<label for="username" class="form-label"><?php print _t("Username"); ?></label>
						<input type="text" class="form-control" id="username" name="username" autocomplete="off" />
					</div>
				</div>
				<div class="row">
					<div class="col mb-4">
						<label for="password" class="form-label"><?php print _t("Password"); ?></label>
						<input type="password" name="password" class="form-control" id="password" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col mb-4">
					<button type="submit" class="btn btn-primary"><?php print _t("Login"); ?></button>
				</div>
			</div>
		</div>
	</div>
				<div class="row mb-4">
<?php
					if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) {
						print '<div class="col-12 mb-2">'.caNavLink($this->request, _t("Click here to register"), "", "", "LoginReg", "registerForm", array()).'</div>';
					}
					print "<div class='col-12 mb-2'>".caNavLink($this->request, _t("Forgot your password?"), "", "", "LoginReg", "resetForm", array()).'</div>';
?>
				</div>
			</form>